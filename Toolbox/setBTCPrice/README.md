# setBTCPrice.php
Tool for retrieving BTC price from multiple exchanges and storing locally for use by getBTCPrice.
* Stores data in /var/www/php/getBTC.json which resides on the php include_path.
* Provides fail-safe redundancy attributes by searching other resources in the instance of 400, 403, or 404 errors at the source.
  - Timestamp may be used to verify that data is "fresh" and if not, allow for automatic shutdown if desired.
* JSON and ASCII file storage is used to simplify and clarify conversion between arrays and text storage.

