# getPrice - Return the current exchange rates for BTC
Focusing predominantly on the USD/BTC echange pair.
## Bitcoin Exchanges Providing Fiat Information:
* [Bitcoinaverage](https://apiv2.bitcoinaverage.com/indices/global/ticker/BTCUSD) - ```https://apiv2.bitcoinaverage.com/indices/global/ticker/BTCXXX```
  - *NOTE: Requires paid API plan.*
  - USD AUD  BRL CAD CNY EUR GBP IDR INR JPY NGN ZAR
* [Bitfinex](https://api.bitfinex.com/v1/pubticker/btcusd) - ```https://api.bitfinex.com/v1/pubticker/btcusd```
  - *USD ONLY*
* [Bitstamp](https://www.bitstamp.net/api/v2/ticker/btcusd/) - ```https://www.bitstamp.net/api/v2/ticker/btcxxx/```
  - **USD EUR**
* [Blockchain](https://blockchain.info/ticker) - '''https://blockchain.info/ticker'''
  - **USD AUD BRL CAD CHF CLP CNY DKK EUR GBP HKD INR ISK JPY KRW NZD PLN RUB SEK SGD THB TRY TWD**
* [BTC_China](https://data.btcchina.com/data/ticker) - ```https://data.btcchina.com/data/ticker``` 
  - *CNY ONLY*
* [Coindesk](http://api.coindesk.com/v1/bpi/currentprice.json) - ```http://api.coindesk.com/v1/bpi/currentprice.json```
  - or ```http://api.coindesk.com/v1/bpi/currentprice/{XXX}.json```
    - USD AUD BRL CAD CNY COP EUR GBP IDR INR JPY ZAR
* [Foxbit](https://api.blinktrade.com/api/v1/BRL/ticker?crypto_currency=BTC) - ```https://api.blinktrade.com/api/v1/BRL/ticker?crypto_currency=BTC```
  - *BRL ONLY*
* [Gemini](https://api.gemini.com/v1/trades/BTCUSD) - ```https://api.gemini.com/v1/trades/BTCUSD```
  - *USD ONLY*
* [Kraken](https://api.kraken.com/0/public/Ticker?pair=XBTUSD) - ```https://api.kraken.com/0/public/Ticker?pair=XBTXXX```
  - USD CAD EUR GBP JPY
  - *coded as:*
    - a = ask array(<price>, <whole lot volume>, <lot volume>),
    - b = bid array(<price>, <whole lot volume>, <lot volume>),
    - c = last trade closed array(<price>, <lot volume>),
    - v = volume array(<today>, <last 24 hours>),
    - p = volume weighted average price array(<today>, <last 24 hours>),
    - t = number of trades array(<today>, <last 24 hours>),
    - l = low array(<today>, <last 24 hours>),
    - h = high array(<today>, <last 24 hours>),
    - o = today's opening price
* [myBitX](https://api.mybitx.com/api/1/ticker?pair=XBT{$fiat}) - '''https://api.mybitx.com/api/1/ticker?pair=XBTNGN'''
