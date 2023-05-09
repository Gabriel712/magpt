function getInputText() {
    var product_name = document.querySelector('div[data-index="name"] input');
    var meta_title = document.querySelector('div[data-index="meta_title"] input');
    var meta_keyword = document.querySelector('div[data-index="meta_keyword"] textarea');
    var meta_description = document.querySelector('div[data-index="meta_description"] textarea'); // 255 chars
    getAjax(product_name, meta_title, meta_keyword, meta_description)
    updateStyle(product_name, meta_title, meta_keyword, meta_description)
}


function getAjax(product_name, meta_title, meta_keyword, meta_description) {

    var url = '/index.php/admin/magpt/Get/Retrieve/';

    const params = {
      'product_name': product_name.value,
      'meta_title': meta_title.value,
      'meta_keyword': meta_keyword.value,
      'meta_description': meta_description.value,
    };

    for (const key in params) {
      if (params[key]) {
        url += `${key}/${params[key]}/`;
      }
    }

    fetch(url)
      .then(response => response.json())
      .then(data => {
        product_name.value = data.product_name;
        meta_title.value = data.meta_title;
        meta_keyword.value = data.meta_keyword;
        meta_description.value = data.meta_description;
      })
      .catch(error => console.error(error));
  }
  

function updateStyle(product_name, meta_title, meta_keyword, meta_description) {
    const backgroundColor = '#00800070';
    product_name.style.backgroundColor = backgroundColor;
    meta_title.style.backgroundColor = backgroundColor;
    meta_keyword.style.backgroundColor = backgroundColor;
    meta_description.style.backgroundColor = backgroundColor;
  }
  
