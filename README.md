# oxid_modules


## bmAdvShipping

Removes shippings if certain conditions apply. i.e. show shipping per letter only
if there are articles from categoy postcards in the basket.

Blende Versandarten nur bei best. Artikel einer Kategorie im WK ein.
Sind andere Artikel einer anderen Kateogrie im WK  wird die Versandart ausgeblendet.

### installation

add to composer & dump-autoload

```
 "autoload": {
    "psr-4": {
        "Bmnnit\\bmAdvShipping\\":  "./source/modules/bmnnit/bmAdvShipping"
    }
  },
```

```
composer dump-autoload -o
```

### configure

map deliveryrule to category like this in config.inc.php

```
 $this->aaDeliveryLimitCategories = array (    
        'a566109caf784e757aead1af2097810b' => array( 
            '728aebc88237cd0f7c7e8d386ee4b76b' //kategorie 
            
        )
    
    ) ; 

```