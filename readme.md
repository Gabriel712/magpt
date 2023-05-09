## MaGPT
Integrate GPT in Magento 2 (Magento ver. 2.4.5-p1)

## Disclaimer
This module is currently in testing phase, do not use it in production stores.

   * To make the module work, it is necessary to change the 'Add Secret Key to URLs' option in the admin panel to NO.

   * Configure your GPT KEY in MAGPT.

Both options can be found in Stores -> Configuration.
## Prompts example

## Portugues
    Responda somente em json.
    { "product_name": "", "meta_title": "","meta_keyword": "","meta_description": ""} 
    Imagine, crie, mas nao deixe campos vazios. 
    product_name:$product_name,meta_title:$meta_title,meta_keyword:$meta_keyword,meta_description:$meta_description

 ## English
    Example prompt for configuration
    Answer only in json.
    { "product_name": "", "meta_title": "","meta_keyword": "","meta_description": ""}
    Imagine, create, but don't leave fields empty.
    product_name:$product_name,meta_title:$meta_title,meta_keyword:$meta_keyword,meta_description:$meta_description
    
![Captura de tela_2023-05-09_20-53-04](https://github.com/Gabriel712/magpt/assets/32819344/07599537-5845-4f42-831a-d5da19b4ec80)
