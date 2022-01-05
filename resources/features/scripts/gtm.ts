Array.from(document.querySelectorAll('[data-event]')).forEach((link) => {
  link.addEventListener('click', function (e) {
    const { event, eventCategory, eventAction, eventLabel } = (
      e.currentTarget as HTMLElement
    ).dataset
    window.dataLayer.push({ event, eventCategory, eventAction, eventLabel })
  })
})

Array.from(document.querySelectorAll('[data-product-click]')).forEach(
  (link) => {
    link.addEventListener('click', function (e) {
      const {
        productClick,
        productName,
        productId,
        productPrice,
        productVariant,
        productPosition,
      } = (e.currentTarget as HTMLElement).dataset

      window.dataLayer.push({
        ecommerce: {
          currencyCode: 'EUR',
          click: {
            actionField: { list: productClick },
            products: [
              {
                name: productName,
                id: productId,
                price: parseInt(productPrice!, 10),
                brand: undefined,
                category: undefined,
                variant: productVariant,
                position: parseInt(productPosition!, 10),
              },
            ],
          },
        },
        event: 'productClick',
      })

      sessionStorage.setItem('dl_product_list_name', productClick!)
    })
  }
)

Array.from(document.querySelectorAll('[data-form-action]')).forEach((form) => {
  form.addEventListener('submit', function (e) {
    const { formAction, formLabel } = (e.currentTarget as HTMLElement).dataset

    window.dataLayer.push({
      event: 'uaevent',
      eventCategory: 'Formulaires',
      eventAction: formAction,
      eventLabel: formLabel,
    })
  })
})

window.addEventListener('load', function () {
  if (window.settings.dl_product) {
    window.dataLayer.push({
      ecommerce: {
        currencyCode: 'EUR',
        detail: {
          actionField: {
            list: sessionStorage.getItem('dl_product_list_name') || 'view',
          },
          products: [
            {
              name: window.settings.dl_product.name,
              id: window.settings.dl_product.id,
              price: window.settings.dl_product.price,
              brand: null,
              category: null,
              variant: 'Residence Domitys Senior',
            },
          ],
        },
      },
      event: 'productView',
    })

    sessionStorage.removeItem('dl_product_list_name')
  }
})
