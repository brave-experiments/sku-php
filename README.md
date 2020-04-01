## Composer plugin to use SKU workflows in Brave

The PHP library consists of:

* **generateSKUToken()** -  You need to generate a SKU token for any item that is being displayed to the user. This function needs to be invoked on every page load for an item. See code [here](https://github.com/brave-experiments/sku-php/blob/master/src/Sku.php#L9)


    Parameters:
    * **sku**: String
    * **amount**: String
    * **currency**: String, should only be “BAT” for now.
    * **description**: String
    * **expiry**: String in RFC3339 format

* **validateOrderStatus** - Once the order id is returned by the rewards service, this wrapper can be used to check if the transaction was completed. See code [here](https://github.com/brave-experiments/sku-php/blob/master/src/Sku.php#L41)

    Parameters:
    * **host**: String,
    * **orderId**: String
