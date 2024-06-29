document.addEventListener("DOMContentLoaded", function () {
  // Mouse Trailer Function
  const trailer = document.getElementById("trailer");
  if (trailer) {
    window.onmousemove = e => {
      const x = e.clientX - trailer.offsetWidth / 2;
      const y = e.clientY - trailer.offsetHeight / 2;
      trailer.style.transform = `translate(${x}px,${y}px)`;
    };
  }

  let productData = null;

  // Function to display products
  function addProduct() {
    let productlistHTML = document.querySelector(".products");
    if (productlistHTML) {
      productlistHTML.innerHTML = "";
      if (productData != null) {
        productData.forEach((product) => {
          let productDiv = document.createElement("div");
          productDiv.className = "wrapper";
          productDiv.innerHTML = `
            <div class="container" data-id="${product.id}">
              <div class="top" style="background: url('${product.image}') no-repeat center; background-size: 60%;"></div>
              <div class="bottom">
                <div class="left">
                  <div class="details">
                    <h2>${product.name}</h2>
                    <p>${product.price}</p>
                  </div>
                  <div class="buy"><img src="/img/cart.png" alt="Cart Icon"></div>
                </div>
              </div>
            </div>
          `;
          productlistHTML.appendChild(productDiv);

          productDiv.querySelector(".container").addEventListener("click", function () {
            let productId = this.getAttribute("data-id");
            window.location.href = "/product_detail.php?id=" + productId;
          });
        });
      }
    }
  }

  // Fetch product data (Example fetch from products.json)
  fetch("products.json")
    .then((response) => response.json())
    .then((data) => {
      if (!Array.isArray(data)) {
        throw new Error("Invalid data format");
      }
      productData = data;
      addProduct();
    })
    .catch((error) => console.error("Error fetching the product data:", error));

  // Toggle Add Product Form
  const addProductBtn = document.getElementById("addProductBtn");
  const addProductForm = document.getElementById("addProductForm");

  if (addProductBtn && addProductForm) {
    addProductBtn.addEventListener("click", () => {
      addProductForm.style.display = addProductForm.style.display === "none" ? "block" : "none";
    });
  }

  // Handle new product form submission
  const newProductForm = document.getElementById("newProductForm");

  if (newProductForm) {
    newProductForm.addEventListener("submit", (event) => {
      event.preventDefault();

      const formData = new FormData(newProductForm);

      fetch("add_product.php", {
        method: "POST",
        body: formData,
      })
        .then(response => response.json())
        .then(data => {
          if (data.success) {
            alert("Product added successfully!");
            location.reload(); // Reload the page to display the new product
          } else {
            alert("Error adding product: " + data.message);
          }
        })
        .catch(error => {
          console.error("Error adding product:", error);
        });
    });
  }

  // Close the form if clicked outside
  document.addEventListener("click", function (event) {
    if (addProductForm && !addProductForm.contains(event.target) && event.target !== addProductBtn) {
      addProductForm.style.display = "none";
    }
  });

  // Function to close the form
  window.closeForm = function () {
    if (addProductForm) {
      addProductForm.style.display = "none";
      document.body.style.overflow = ""; // Restore scrolling on background content
    }
  };

  // FAQ Accordions
  const accordions = document.querySelectorAll(".accordion");
  accordions.forEach((accordion) => {
    const question = accordion.querySelector(".question");
    const arrow = accordion.querySelector(".arrow");
    const answer = accordion.querySelector(".answer");

    question.addEventListener("click", () => {
      const isActive = accordion.classList.contains("active");

      accordions.forEach((acc) => {
        acc.classList.remove("active");
        acc.querySelector(".arrow").classList.remove("active");
        acc.querySelector(".answer").style.maxHeight = null;
      });

      if (!isActive) {
        accordion.classList.add("active");
        arrow.classList.add("active");
        answer.style.maxHeight = answer.scrollHeight + "px";
      } else {
        accordion.classList.remove("active");
        arrow.classList.remove("active");
        answer.style.maxHeight = null;
      }
    });
  });

  // Clock
  function updateClock() {
    const clockElements = document.querySelectorAll(".clock");
    const now = new Date();
    const hours = now.getHours().toString().padStart(2, "0");
    const minutes = now.getMinutes().toString().padStart(2, "0");
    const seconds = now.getSeconds().toString().padStart(2, "0");

    clockElements.forEach((clockElement) => {
      clockElement.textContent = `${hours}:${minutes}:${seconds}`;
    });
  }

  setInterval(updateClock, 1000); // Update the clock every second
  updateClock(); // Initial call to display the clock immediately

  // Pop up message on cards
  var modal = document.getElementById("myModal");
  var modalContent = document.getElementById("modalContent");
  var modalImage = document.getElementById("modalImage"); // Add this line to get the modal image container

  // Function to open the modal and display product information
  function openModal(productInfo, imageUrl) {
    if (modal && modalContent && modalImage) {
      modal.style.display = "block";
      modalContent.innerHTML = productInfo;
      modalImage.innerHTML = "<img src='" + imageUrl + "' alt='Product Image'>";
    }
  }

  // Function to close the modal
  function closeModal() {
    if (modal) {
      modal.style.display = "none";
    }
  }

  // Close the modal when clicking outside the modal content
  window.onclick = function (event) {
    if (modal && event.target == modal) {
      closeModal();
    }
  };

  // Close the modal when pressing the escape key
  document.addEventListener("keydown", function (event) {
    if (event.key === "Escape") {
      closeModal();
    }
  });

  // Attach click event listener to each product card
  var productCards = document.querySelectorAll(".card");
  productCards.forEach(function (card) {
    card.addEventListener("click", function () {
      var productInfo = this.querySelector(".sci").innerHTML;
      var imageUrl = this.querySelector(".imgBx img").src;
      openModal(productInfo, imageUrl);
    });
  });

  // Combo box state
  var states = [
    "Johor", "Kedah", "Kelantan", "Melaka", "Negeri Sembilan", "Pahang",
    "Perak", "Perlis", "Penang", "Sabah", "Sarawak", "Selangor", "Terengganu",
    "Wilayah Persekutuan Kuala Lumpur", "Wilayah Persekutuan Labuan",
    "Wilayah Persekutuan Putrajaya"
  ];

  var stateInput = document.getElementById("stateInput");
  if (stateInput) {
    var datalist = document.createElement("datalist");
    datalist.id = "states";

    states.forEach(function (state) {
      var option = document.createElement("option");
      option.value = state;
      datalist.appendChild(option);
    });

    stateInput.setAttribute("list", "states");
    stateInput.parentNode.appendChild(datalist);

    // Initialize Select2 on the state input field
    $("#stateInput").select2({
      placeholder: "Select a state",
      width: "100%",
      theme: "bootstrap4",
      dropdownAutoWidth: true,
      data: states.map(function (state) {
        return { id: state, text: state };
      }),
      matcher: function (params, data) {
        // If there are no search terms, return all options
        if ($.trim(params.term) === "") {
          return data;
        }

        // Check if the option starts with the search term
        if (data.text.toUpperCase().indexOf(params.term.toUpperCase()) === 0) {
          return data;
        }

        // If the option does not match, do not include it
        return null;
      },
    });
  }
});
