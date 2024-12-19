document.addEventListener("DOMContentLoaded", function () {
  const placeOrderBtn = document.getElementById("place-order-btn");
  const sectionsContainer = document.getElementById("sections-container");
  const prices = {
    "5mm": { black: 1100, blue: 115, clear: 120, green: 125 },
    "6mm": { black: 140, blue: 145, clear: 150, green: 155 },
    "8mm": { black: 190, blue: 195, clear: 200, green: 205 },
    "10mm": { black: 250, blue: 255, clear: 260, green: 265 },
    "12mm": { black: 300, blue: 305, clear: 310, green: 315 },
  };

  // Create a new section
  function createSection() {
    const section = document.createElement("div");
    section.className = "section";
    section.innerHTML = `
            <div class="selectors">
                <select class="unit-selector">
                    <option value="inches">Inches</option>
                    <option value="cm">Cm</option>
                </select>
                <select class="thickness-selector">
                    <option value="5mm">5mm</option>
                    <option value="6mm">6mm</option>
                    <option value="8mm">8mm</option>
                    <option value="10mm">10mm</option>
                    <option value="12mm">12mm</option>
                </select>
                <select class="color-selector">
                    <option value="black">Black</option>
                    <option value="blue">Blue</option>
                    <option value="clear">Clear</option>
                    <option value="green">Green</option>
                </select>
                <button id="remove-btn" onclick="removeSection(this)">&times;Section</button>
            </div>
            <div class="input-container">
                <div class="input-group">
                    <input type="number" placeholder="Length" class="length">
                    <input type="number" placeholder="Breadth" class="breadth">
                    <button class="remove-btn" onclick="removeGroup(this)">&times;</button>
                    <div class="result-display"></div>
                </div>
            </div>
            <button class="add-box-btn" onclick="addInputGroup(this)">+</button><hr>
            
        `;
    sectionsContainer.appendChild(section);
  }

  // Add input group within a section
  window.addInputGroup = function (button) {
    const section = button.closest(".section");
    const inputContainer = section.querySelector(".input-container");
    const inputGroup = document.createElement("div");
    inputGroup.className = "input-group";
    inputGroup.innerHTML = `
            <input type="number" placeholder="Length" class="length">
            <input type="number" placeholder="Breadth" class="breadth">
            <button class="remove-btn" onclick="removeGroup(this)">&times;</button>
            <div class="result-display"></div>
        `;
    inputContainer.appendChild(inputGroup);
  };

  // Remove input group
  window.removeGroup = function (button) {
    button.closest(".input-group").remove();
  };
  window.removeSection = function (button) {
    button.closest(".section").remove();
  };

  // Round input based on defined ranges
  function roundInput(value) {
    if (value >= 6 && value <= 9) return 9;
    if (value > 9 && value <= 12) return 12;
    if (value > 12 && value <= 18) return 18;
    if (value > 18 && value <= 24) return 24;
    if (value > 24 && value <= 30) return 30;
    if (value > 30 && value <= 36) return 36;
    if (value > 36 && value <= 42) return 42;
    if (value > 42 && value <= 48) return 48;
    if (value > 48 && value <= 60) return 60;
    if (value > 60 && value <= 72) return 72;
    if (value > 72 && value <= 84) return 84;
    if (value > 84 && value <= 96) return 96;
    if (value > 96 && value <= 108) return 108;
    if (value > 108 && value <= 120) return 120;
    return value;
  }

  // Convert cm to inches
  function convertCmToInches(value) {
    return value / 2.54;
  }

  // Function to calculate total for all sections
  window.calculateTotal = function () {
    const sections = document.querySelectorAll(".section");
    let totalSquareFeet = 0;
    let totalPrice = 0;
    let hasValidValues = false; //Flag to check if any valid input is present

    sections.forEach(function (section) {
      const unitSelector = section.querySelector(".unit-selector");
      const thicknessSelector = section.querySelector(".thickness-selector");
      const colorSelector = section.querySelector(".color-selector");
      const inputGroups = section.querySelectorAll(".input-group");

      inputGroups.forEach(function (group) {
        const lengthInput = group.querySelector(".length");
        const breadthInput = group.querySelector(".breadth");
        const resultDisplay = group.querySelector(".result-display");

        let length = parseFloat(lengthInput.value);
        let breadth = parseFloat(breadthInput.value);

        // Convert from cm to inches if necessary
        if (unitSelector.value === "cm") {
          length = convertCmToInches(length);
          breadth = convertCmToInches(breadth);
        }

        // Round the input values
        length = roundInput(length);
        breadth = roundInput(breadth);

        if (!isNaN(length) && !isNaN(breadth) && length > 0 && breadth > 0) {
          hasValidValues = true; //At least one valid input exists
          const squareFeet = (length * breadth) / 144;
          totalSquareFeet += squareFeet;

          const pricePerSqFt =
            prices[thicknessSelector.value][colorSelector.value];
          if (pricePerSqFt) {
            const price = squareFeet * pricePerSqFt;
            totalPrice += price;

            resultDisplay.innerHTML = `Sq ft: ${squareFeet.toFixed(
              2
            )}, Price: NRS ${price.toFixed(2)}`;
          } else {
            console.error(
              `Price for thickness "${thicknessSelector.value}" and color "${colorSelector.value}" not found.`
            );
            resultDisplay.innerHTML = `Error: Price information not available.`;
          }
        } else {
          console.error(
            `Invalid length or breadth: length=${length}, breadth=${breadth}`
          );
        }
      });
    });

    //////////////////////////New///////////////////////////////
    //shows the 'Place Order' btn only if valid input exist

    if (hasValidValues) {
      placeOrderBtn.style.display = "inline-block"; // Show the button

      // Display total result
      document.getElementById(
        "result"
      ).innerHTML = `Total Sq ft: ${totalSquareFeet.toFixed(
        2
      )}, Total Price: NRS ${totalPrice.toFixed(2)}`;
    } else {
      alert("Please Input values for calculation!");
      placeOrderBtn.style.display = "none"; // Hide the button
    }
  };
  //checks if user is logged in and handle 'place order'
  placeOrderBtn.addEventListener("click", function () {
    const orderStatusDiv = document.getElementById('order-status');
    const sections = document.querySelectorAll(".section");
    const orders = [];
    let totalPrice = 0;
    let totalSquareFeet = 0;

    sections.forEach((section) => {
      const unitSelector = section.querySelector(".unit-selector");
      const thicknessSelector = section.querySelector(".thickness-selector");
      const colorSelector = section.querySelector(".color-selector");
      const inputGroups = section.querySelectorAll(".input-group");

      inputGroups.forEach((group) => {
        const lengthInput = group.querySelector(".length").value;
        const breadthInput = group.querySelector(".breadth").value;
        const unitSel = unitSelector.value;
        const colorSel = colorSelector.value;
        const thicknessSel = thicknessSelector.value;

        let squareFeet = (lengthInput * breadthInput) / 144;
        totalSquareFeet += squareFeet;

        const pricePerSqFt =
          prices[thicknessSelector.value][colorSelector.value];
        let price = squareFeet * pricePerSqFt;
        totalPrice += price;

        if (lengthInput && breadthInput) {
          orders.push({
            length: lengthInput,
            breadth: breadthInput,
            total_sqr_ft: totalSquareFeet.toFixed(2),
            total_price: totalPrice.toFixed(2),
            unitSel,
            colorSel,
            thicknessSel,
          });
        }
      });
    });

    if (orders.length === 0) {
      document.getElementById("statusMessage").innerText =
        "Please provide order details!";
      return;
    }
    document.getElementById("statusMessage").innerText =
      "Your order is being processed. Please wait...";
    document.getElementById("statusMessage").style.color = "darkorange";

    fetch("calculate.php", {
      method: "POST",
      headers: { "Content-Type": "application/x-www-form-urlencoded" },
      body: new URLSearchParams({
        place_order: "1",
        orders: JSON.stringify(orders),
      }),
    })
      .then((response) => response.json())
      .then((data) => {
        const statusMessageDiv = document.getElementById("statusMessage");

        if (data.success) {
          // Display success message
          alert(data.alert);
        
          statusMessageDiv.innerText = data.statusMessage; // "Your order is pending."
          statusMessageDiv.style.color = "green";
        } else {
          statusMessageDiv.style.display = "none";
          if (data.alert) {
            alert(data.alert);
          }
        }
        setTimeout(() => {
          window.location.reload();
        }, 2000);
      })
      .catch((error) => {
        console.error("Error:", error);
        document.getElementById("statusMessage").style.color = 'red';
        document.getElementById("statusMessage").innerHTML =
        "<p style ='color: red' >Something went wrong. Please try again.</p>";
          
      });
  });






  // Add new section
  window.addNewSection = function () {
  
    createSection();
    
  };

  // Initialize the first section
  createSection();

  // Add event listener for "New Section" button
  document
    .getElementById("new-section-btn")
    .addEventListener("click", addNewSection);

  // Add event listener for "Calculate Total" button
  document
    .getElementById("calculate-total-btn")
    .addEventListener("click", calculateTotal);
});


document.addEventListener("DOMContentLoaded", function() {
  // Check if the user is logged in by looking at the data attribute
  const isLoggedIn = document.querySelector('#calc-container').dataset.logggedIn === 'true';
  
  if (isLoggedIn) {
      fetchOrders(); // Fetch orders on page load if logged in
  }
});

function fetchOrders() {
  // Send AJAX request to fetch orders from the server
  fetch("calculate.php?fetch_order=true")
      .then(response => response.json())
      .then(data => {
          if (data.success) {
              displayOrders(data.orders); // If orders are found, display them
          } else {
              document.getElementById("order-status-content").innerHTML = "<p>No orders found.</p>"; // Show message if no orders
              
          }
      })
      .catch(error => {
          console.error("Error fetching orders:", error);
          document.getElementById("order-status").innerHTML = "<p>Error loading orders.</p>";
      });
}

function displayOrders(orders) {
  // Create the unordered list to display orders
  const orderStatusDiv = document.getElementById("order-status-content");
 
  const ul = document.createElement("ul");
  orders.forEach(order => {
      const li = document.createElement("li");
      li.textContent = `Order ${order.order_id}: ${order.status}`;
      ul.appendChild(li);
      
  });

  orderStatusDiv.appendChild(ul);
  
}
