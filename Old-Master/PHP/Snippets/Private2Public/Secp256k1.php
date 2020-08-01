<?php
class Secp256k1
{
	private $even = false;
	private $compressed = false;
	private $wif_prefixes = array(
		'9',
		'5',
		'K',
		'L'
	);

	public function private2public($privateKey, $compressed = true)
	{	
		# Test whether private key is NOT Hex encoded
		if (strlen($privateKey) != 64) {
			# Test whether private key is WIF encoded. Will throw error if input length is <1
			try {
				$privateKey = $this->wif2key($privateKey);
			} catch (Exception $e) {
				return $e->getMessage();
			}
		}else {
			$this->compressed = $compressed;
		}
	
		$p	= "115792089237316195423570985008687907853269984665640564039457584007908834671663";
		$Gx	= "55066263022277343669578718895168534326250603453777594175500187360389116729240";
		$Gy	= "32670510020758816978083085130507043184471273380659243275938904335757337482424";
		$g	= array(
			$Gx,
			$Gy
		);
		$n	= $this->bchexdec($privateKey);
		$pair	= $this->ptmul($g, $n, $p);
		$pubKey = $this->pairToKey($pair);
		if ($this->compressed) {
			if ($this->even) {
				return '02' . $pubKey;
			} else {
				return '03' . $pubKey;
			}
		} else {
			return '04' . $pubKey;
		}
	}

	private function pairToKey($array)
	{
		list($x, $y) = $array;
		$x = $this->bcdechex($x);
		$y = $this->bcdechex($y);
		$this->even = (hexdec(substr($y, -1)) % 2 == 0);
		return ($this->compressed) ? $x : $x . $y;
	}
	
	# WARNING: DOES NOT VERIFY CHECKSUM!
	private function wif2key($wif)
	{
		if(strlen($wif) != 51 && strlen($wif) != 52) {
			# Throw exception if WIF isn't valid size
			throw new Exception("Private Key (WIF) is not a valid length.");
		}
		$wif_prefix = substr($wif, 0, 1);
		if(!in_array($wif_prefix, $this->wif_prefixes)) {
			# Throw exception if given WIF does not start with a valid WIF prefix
			throw new Exception("Private Key (WIF) does not have a valid prefix.");
		}
		# WIF encodes whether private key represents a compressed/uncompressed public key, so check prefix
		$this->compressed = ($wif_prefix == 'K' || $wif_prefix == 'L');
		# WIF that encodes a compressed public key has an extra 0x01 byte at the end, so narrow substr range by 2 if compressed
		# Last 8 bytes will always be the checksum
		$end = $this->compressed ? -10 : -8;
		return substr($this->base58Decode($wif), 2, $end);
	}
	
	private function base58Decode($hex)
	{
		//create val to char array
		$string	= '123456789ABCDEFGHJKLMNPQRSTUVWXYZabcdefghijkmnopqrstuvwxyz';
		$int_val = "0";
		for ($i = strlen($hex) - 1, $j = "1", $base = strlen($string); $i >= 0; $i--, $j = gmp_mul($j, $base)) {
			$q	= @gmp_mul($j, strval(strpos($string, $hex{$i})));
			$int_val = gmp_add($int_val, $q);
		}
		$hex = $this->bcdechex($int_val);
		if (strlen($hex) == 47) {
			$hex = '0' . $hex; //sometimes the first characters (0?) gets cut off. Why?
		}
		return $hex;
	}
	
	private function bcdechex($dec)
	{
		$hex = '';
		do {
			$last = bcmod($dec, 16);
			$hex	= dechex($last) . $hex;
			$dec	= bcdiv(bcsub($dec, $last), 16);
		} while ($dec > 0);
		return str_pad($hex, 64, "0", STR_PAD_LEFT);
	}
	
	private function bchexdec($hex)
	{
		$dec = 0;
		$len = strlen($hex);
		for ($i = 1; $i <= $len; $i++) {
			$dec = bcadd($dec, bcmul(strval(hexdec($hex[$i - 1])), bcpow('16', strval($len - $i))));
		}
		$decArray = explode('.', $dec);
		$dec = $decArray[0];
		return $dec;
	}
	
	private function ptmul($pt, $a, $p)
	{
		$scale = $pt;
		$acc = null;
		while (substr($a, 0) != "0") {
			if (gmp_mod($a, 2) != "0") {
				if ($acc == null) {
					$acc = $scale;
				} else {
					$acc = $this->addpt($acc, $scale, $p);
				}
			}
			$scale = $this->dblpt($scale, $p);
			$a	= gmp_div($a, 2);
		}
		return $acc;
	}
	
	private function addpt($p1, $p2, $p)
	{
		if ($p1 == null || $p2 == null) {
			return null;
		}
		list($x1, $y1) = $p1;
		list($x2, $y2) = $p2;
		if ($x1 == $x2) {
			return $this->dblpt($p1, $p);
		}
		$slope = gmp_mul(gmp_sub($y1, $y2), $this->inverse(gmp_sub($x1, $x2), $p));
		$xsum	= gmp_sub(gmp_mod(gmp_pow($slope, 2), $p), gmp_add($x1, $x2));
		$ysum	= gmp_sub(gmp_mul($slope, gmp_sub($x1, $xsum)), $y1);
		return array(
			gmp_mod($xsum, $p),
			gmp_mod($ysum, $p)
		);
	}
	
	private function dblpt($point, $p)
	{
		if (is_null($point)) {
			return null;
		}
		list($x, $y) = $point;
		if ($y == "0") {
			return null;
		}
		$slope = gmp_mul(gmp_mul(3, (gmp_mod(gmp_pow($x, 2), $p))), $this->inverse(gmp_mul(2, $y), $p));
		$xsum	= gmp_sub(gmp_mod(gmp_pow($slope, 2), $p), gmp_mul(2, $x));
		$ysum	= gmp_sub(gmp_mul($slope, (gmp_sub($x, $xsum))), $y);
		return array(
			gmp_mod($xsum, $p),
			gmp_mod($ysum, $p)
		);
	}
	
	private function inverse($x, $p)
	{
		$inv1 = "1";
		$inv2 = "0";
		
		while ($p != "0" && $p != "1") {
			list($inv1, $inv2) = array(
				$inv2,
				gmp_sub($inv1, gmp_mul($inv2, gmp_div_q($x, $p)))
			);
			list($x, $p) = array(
				$p,
				gmp_mod($x, $p)
			);
		}
		return $inv2;
	}
}
?>
