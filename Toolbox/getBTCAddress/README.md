# getBTCAddress
Function that returns an address of an account defined in the [getBTC.conf][conf-file] file at a specific index.

## Inputs
- Account Name
  - Type: string
  - Restrictions:
    - Must be defined in the [getBTC.conf][conf-file] file
  - Description: Name of the account in [getBTC.conf][conf-file] that refers to an extended public key
- Child Index
  - Type: integer
  - Restrictions:
    - Must be in the range `0 <= x < 2^31`
  - Description: Index of the Address to derive

## Outputs
- Bitcoin Address
  - Type: string
  - Description: Address of the given account extended public key at the given index

## Usage

### Java
Currently a WIP.

### Javascript
Currently a WIP.

### PHP
Currently a WIP.

### Python
Currently a WIP.

### Ruby
Currently a WIP.

[conf-file]: Toolbox/getBTC.conf
