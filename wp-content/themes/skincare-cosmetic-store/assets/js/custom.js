// Scroll to Top
window.onscroll = function() {
  const skincare_cosmetic_store_button = document.querySelector('.scroll-top-box');
  if (skincare_cosmetic_store_button) {
    if (document.body.scrollTop > 100 || document.documentElement.scrollTop > 100) {
      skincare_cosmetic_store_button.style.display = "block";
    } else {
      skincare_cosmetic_store_button.style.display = "none";
    }
  }
};

const scrollTopLink = document.querySelector('.scroll-top-box a');
if (scrollTopLink) {
  scrollTopLink.onclick = function(event) {
    event.preventDefault();
    window.scrollTo({ top: 0, behavior: 'smooth' });
  };
}

// banner
jQuery(document).ready(function() {
  jQuery('.banner-sec .owl-carousel').owlCarousel({
    loop: true,
    margin: 30,
    nav: true,
    dots: true,
    rtl: false,
    navText: [
      '<span class="custom-arrow prev-arrow"><i class="fa-solid fa-arrow-left"></i></span>',
      '<span class="custom-arrow next-arrow"><i class="fa-solid fa-arrow-right"></i></span>'
    ],
    responsive: {
      0: { 
        items: 1 
      },
      600: { 
        items: 1 
      },
      1025: { 
        items: 1
      },
      1200: { 
        items: 1
      }
    },
    autoplay: false
  });
});

//  Single Product Link
document.addEventListener("click", function(e) {
  const skincare_cosmetic_store_btn = e.target.closest(".product-section .products-sec-box .product-btn");
  if (!skincare_cosmetic_store_btn) return;

  // No interceptar el boton nativo de WooCommerce "Anadir al carrito":
  // debe agregar el producto al carrito sin navegar.
  if (e.target.closest("button, .add_to_cart_button, .ajax_add_to_cart, .wc-block-components-product-button__button")) return;

  const skincare_cosmetic_store_productItem = skincare_cosmetic_store_btn.closest("li.product");
  if (!skincare_cosmetic_store_productItem) return;

  const skincare_cosmetic_store_productLink = skincare_cosmetic_store_productItem.querySelector("a[href*='/product/']");
  if (skincare_cosmetic_store_productLink) {
    window.location.href = skincare_cosmetic_store_productLink.getAttribute("href");
  }
});

jQuery(document).ready(function() {
  jQuery('.blog-sec .owl-carousel').owlCarousel({
    loop: true,
    margin: 20,
    nav: false,
    dots: false,
    rtl: false,
    responsive: {
    0: { 
      items: 1 
    },
    600: { 
      items: 2
    },
    1000: { 
      items: 3
    },
    1200: { 
      items: 3
    }
  },
    autoplay: false,
  });
});