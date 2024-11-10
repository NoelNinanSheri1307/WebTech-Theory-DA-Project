<?php
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Energy Bill Calculator</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family:Footlight MT Light;
        }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: gold;
            color: #333;
            line-height: 1.6;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 80%;
            max-width: 900px;
            margin: 50px auto;  
            background-color:bisque;
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            padding: 40px;
        }

        h1 {
            text-align: center;
            font-size: 2.5em;
            margin-bottom: 20px;
            color: #2b3e50;
        }

        .intro-text {
            text-align: center;
            font-size: 1.2em;
            color: #555;
            margin-bottom: 30px;
        }

        .appliance {
            margin-bottom: 25px;
            padding: 15px;
            border-radius: 8px;
            background-color: #f9fafc;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
        }

        .appliance:hover {
            background-color: #f0f4f8;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .appliance label {
            font-size: 1.1em;
            display: inline-block;
            margin-right: 10px;
            color: #4a5568;
        }

        .input-group {
            display: none;
            margin-top: 15px;
            padding-left: 20px;
        }

        .input-group input {
            width: 120px;
            padding: 10px;
            margin: 5px;
            border-radius: 6px;
            border: 1px solid #ddd;
            background-color: #fff;
            font-size: 1em;
        }

        .input-group label {
            font-size: 1em;
            margin-right: 10px;
            color: #2d3748;
        }

        button {
            background-color: #3498db;
            color: #fff;
            font-size: 1.2em;
            border: none;
            padding: 15px 30px;
            border-radius: 8px;
            width: 100%;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        button:hover {
            background-color: #2980b9;
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.2);
        }

        .bill-table {
            margin-top: 30px;
            width: 100%;
            border-collapse: collapse;
            text-align: center;
        }

        .bill-table th, .bill-table td {
            padding: 12px;
            border: 1px solid #ddd;
            font-size: 1.1em;
        }

        .bill-table th {
            background-color: #3498db;
            color: white;
        }

        .bill-table td {
            background-color: #f9fafc;
        }

        .total-row td {
            font-weight: bold;
            background-color: #f0f4f8;
        }

        @media (max-width: 768px) {
            .container {
                padding: 20px;
                width: 95%;
            }

            .input-group input {
                width: 100%;
                margin-top: 10px;
            }

            h1 {
                font-size: 2em;
            }

            .intro-text {
                font-size: 1.1em;
            }
        }
    </style>
  
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
</head>
<body>
    <div class="container">
        <h1>Energy Bill Calculator</h1>
        <div class="intro-text">
            <p>Welcome to the Energy Bill Calculator! Use this tool to estimate the total energy cost for household appliances.</p>
            <p>Select the appliances you are using and enter the required information.</p>
        </div>
        
        <form id="calculatorForm">
           
            <div class="appliance">
                <label>
                    <input type="checkbox" class="appliance-checkbox"> Air Conditioner
                </label>
                <div class="input-group">
                    <label>Hours Used:</label>
                    <input type="number" class="hours-input" min="0" placeholder="Hours">
                    <label>Energy Consumption (kWh/hour):</label>
                    <input type="number" class="energy-input" min="0" step="0.1" placeholder="Energy (kWh)">
                </div>
            </div>

           
            <div class="appliance">
                <label>
                    <input type="checkbox" class="appliance-checkbox"> Refrigerator
                </label>
                <div class="input-group">
                    <label>Hours Used:</label>
                    <input type="number" class="hours-input" min="0" placeholder="Hours">
                    <label>Energy Consumption (kWh/hour):</label>
                    <input type="number" class="energy-input" min="0" step="0.1" placeholder="Energy (kWh)">
                </div>
            </div>

           
            <div class="appliance">
                <label>
                    <input type="checkbox" class="appliance-checkbox"> Washing Machine
                </label>
                <div class="input-group">
                    <label>Hours Used:</label>
                    <input type="number" class="hours-input" min="0" placeholder="Hours">
                    <label>Energy Consumption (kWh/hour):</label>
                    <input type="number" class="energy-input" min="0" step="0.1" placeholder="Energy (kWh)">
                </div>
            </div>

            
            <div class="appliance">
                <label>
                    <input type="checkbox" class="appliance-checkbox"> Microwave
                </label>
                <div class="input-group">
                    <label>Hours Used:</label>
                    <input type="number" class="hours-input" min="0" placeholder="Hours">
                    <label>Energy Consumption (kWh/hour):</label>
                    <input type="number" class="energy-input" min="0" step="0.1" placeholder="Energy (kWh)">
                </div>
            </div>

            
            <div class="appliance">
                <label>
                    <input type="checkbox" class="appliance-checkbox"> TV
                </label>
                <div class="input-group">
                    <label>Hours Used:</label>
                    <input type="number" class="hours-input" min="0" placeholder="Hours">
                    <label>Energy Consumption (kWh/hour):</label>
                    <input type="number" class="energy-input" min="0" step="0.1" placeholder="Energy (kWh)">
                </div>
            </div>

            
            <div class="appliance">
                <label>
                    <input type="checkbox" class="appliance-checkbox"> Lights
                </label>
                <div class="input-group">
                    <label>Hours Used:</label>
                    <input type="number" class="hours-input" min="0" placeholder="Hours">
                    <label>Energy Consumption (kWh/hour):</label>
                    <input type="number" class="energy-input" min="0" step="0.1" placeholder="Energy (kWh)">
                </div>
            </div>

            
            <div class="appliance">
                <label>
                    <input type="checkbox" class="appliance-checkbox"> Heater
                </label>
                <div class="input-group">
                    <label>Hours Used:</label>
                    <input type="number" class="hours-input" min="0" placeholder="Hours">
                    <label>Energy Consumption (kWh/hour):</label>
                    <input type="number" class="energy-input" min="0" step="0.1" placeholder="Energy (kWh)">
                </div>
            </div>

            <button type="button" id="calculateBtn">Calculate Total Bill</button>
        </form>

       
        <table class="bill-table" id="billTable" style="display:none;">
            <thead>
                <tr>
                    <th>Appliance</th>
                    <th>Energy Consumed (kWh)</th>
                    <th>Cost per kWh (₹)</th>
                    <th>Total Cost (₹)</th>
                </tr>
            </thead>
            <tbody id="billTableBody"></tbody>
            <tfoot>
                <tr class="total-row">
                    <td colspan="3">Total Bill</td>
                    <td id="totalBillAmount">₹0.00</td>
                </tr>
            </tfoot>
        </table>
    </div>

    <script>
        document.querySelectorAll('.appliance-checkbox').forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                const inputGroup = this.parentElement.nextElementSibling;
                inputGroup.style.display = this.checked ? 'block' : 'none';
            });
        });

        document.getElementById('calculateBtn').addEventListener('click', function() {
            let totalBill = 0;
            const tableBody = document.getElementById('billTableBody');
            tableBody.innerHTML = '';

            document.querySelectorAll('.appliance').forEach(appliance => {
                const checkbox = appliance.querySelector('.appliance-checkbox');
                if (checkbox.checked) {
                    const hours = appliance.querySelector('.hours-input').value;
                    const energyPerHour = appliance.querySelector('.energy-input').value;

                    if (hours && energyPerHour) {
                        const energyConsumed = hours * energyPerHour;
                        const costPerKWh = 10; 
                        const totalCost = energyConsumed * costPerKWh;
                        totalBill += totalCost;

                        const row = document.createElement('tr');
                        row.innerHTML = `
                            <td>${appliance.querySelector('label').textContent.trim()}</td>
                            <td>${energyConsumed.toFixed(2)}</td>
                            <td>₹${costPerKWh}</td>
                            <td>₹${totalCost.toFixed(2)}</td>
                        `;
                        tableBody.appendChild(row);
                    }
                }
            });

        
            document.getElementById('totalBillAmount').textContent = `₹${totalBill.toFixed(2)}`;
            document.getElementById('billTable').style.display = totalBill > 0 ? 'table' : 'none';
        });
    </script>
</body>
</html>