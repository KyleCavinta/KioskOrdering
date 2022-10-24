<?php
    include '../includes/header.php';
    include '../includes/navbar.php';
?>
<link rel="stylesheet" href="../styles/reports.css?v=<?php echo time()?>">

<div class="modal" id="">
<div class="header">Feedback
</div>
<div class="body">Yow</div>
</div>


<div class="text-1">
<h4 class="name">Reports</h4>
<hr class = line-1>
</div>

<!-- total orders and Best Sellers -->
<div class = "feedsell">
<div class = "box">


<!-- total orders chart -->
<div class = "totalorders">
<h2 class="torder1">TOTAL ORDERS MADE</h2>
<h2 class="ordernum1">1000</h2>
    </div> 
    <div>
    </div>
</div>



<div class = "box">
<h5 class="reports">Best Sellers</h5>
<hr class = line-2>
<div class="selecttype">
<select id="foodcategory"  class ="ordertype">
    <option value="Pizza">Pizza</option>
    <option value="Pasta">Pasta</option>
    <option value="Chicken">Chicken</option>
    <option value="Drinks">Drinks</option>
    
</select>
</div>
<div class="variety">
<table id="fcategory">
                <thead>
                    <tr>
                        <td>Food ID</td>
                        <td>Flavor</td>
                        <td>Total Sold</td>
                       
                    </tr>
                </thead>
                <tbody>
                </tbody>
                
            </table>

</div>
    <div>
   
        <button class="preview" data-modal= "modaltable">Preview</button>
        
        </div>
    </div>
    
</div>



<!-- Average Visitors and Payment Method -->

<div class = visitpay>

<div class ="box">
<h5 class="reports">Average User Load</h5>
<hr class = line-2>
<div class="timetype">
<select id="weeks" class ="timeline">
    <option value="This Week">This Week</option>
    <option value="Last Week">Last Week</option>
   
</select>
</div>
<!-- Visitors load -->
<div class = "chartcontainer-line">
     <canvas id="custno"></canvas>
    </div>
    <div>
        
    </div>
</div>

<div class ="box">
<h5 class="reports">Payment Method</h5>
<hr class = line-2>
<!-- Paymeth chart -->
<div class = "chart container">
     <canvas id="earning"></canvas>
    </div>
    <div>
    <hr class = line-4>
    </div>
</div>
</div>

 ------------------- ----------------->
<div id="modaltable" class="modalprev">
    <div class ="modal-content">
<!------------------- ----------------->        
    <div class = "box">
<div class="close"><i class="fas fa-times" aria-hidden="true"></i></div> 
<h5 class="reports">Best Sellers</h5>
<hr class = line-2>

<div class="tableresults">
<table>
                <thead>
                    <tr>
                        <td>Item #</td>
                        <td>Flavor</td>
                        <td>Total Sold</td>
                       
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td>Pepperoni</td>
                        <td>10</td>
                    </tr>

                    <tr>
                        <td>2</td>
                        <td>Hawaiian</td>
                        <td>10</td>
                    </tr>

                    <tr>
                        <td>3</td>
                        <td>Bbq Chicken</td>
                        <td>10</td>
                    </tr>

                    <tr>
                        <td>4</td>
                        <td>Garden Special</td>
                        <td>10</td>
                    </tr>

                    <tr>
                        <td>5</td>
                        <td>Manhattan Meatlovers</td>
                        <td>10</td>
                    </tr>

                    <tr>
                        <td>6</td>
                        <td>Roasted Garlic and Shrimp</td>
                        <td>10</td>
                    </tr>

                    <tr>
                        <td>7</td>
                        <td>4 Cheese</td>
                        <td>10</td>
                    </tr>

                    <tr>
                        <td>8</td>
                        <td>Patty Melt</td>
                        <td>10</td>
                    </tr>

                    <tr>
                        <td>9</td>
                        <td>For Seasons All Meat</td>
                        <td>10</td>
                    </tr>

                    <tr>
                        <td>10</td>
                        <td>Four Season Original</td>
                        <td>10</td>
                    </tr>

                    <tr>
                        <td>11</td>
                        <td>New York's Finest</td>
                        <td>10</td>
                    </tr>

                    <tr>
                        <td>12</td>
                        <td>Garlic Shrimp</td>
                        <td>10</td>
                    </tr>

                    <tr>
                        <td>13</td>
                        <td>Darla</td>
                        <td>10</td>
                    </tr>

                    <tr>
                        <td>14</td>
                        <td>Chicken Alfredo</td>
                        <td>10</td>
                    </tr>

                </tbody>
                
            </table>

</div>






    <div>
    <hr class = line-3>
<button class="print" onclick="prints()">Print</button>
    </div>
</div>
<!------------------- ----------------->         
    </div>
</div>

<div id="modalvisit" class="modalprev">
  
    <div class ="modal-content">
<!------------------- -----------------> 

    <div class = "box">
<div class="close"><i class="fas fa-times" aria-hidden="true"></i></div>     
<h5 class="reports">Average User Load</h5>
<hr class = line-2>
<div class = "visitresults">
<img src ="../img/Capture2.JPG"  width= "90%" >
    </div>
    <div>
    <hr class = line-3>
<button class="print" onclick="prints()">Print</button>
    </div>
</div>
 <!------------------- ----------------->        
    </div>
</div>

<div id="modalpayment" class="modalprev">
    <div class ="modal-content">
<!------------------- ----------------->  

    <div class = "box">
<div class="close"><i class="fas fa-times" aria-hidden="true"></i></div> 
<h5 class="reports">Payment Method</h5>
<hr class = line-2>
<div class = "paymentresults">
<img src ="../img/Capture3.JPG">
    </div>
    <div>
    <hr class = line-3>
<button class="print" onclick="prints()">Print</button>
    </div>
</div>
<!------------------- ----------------->       
    </div>
</div>





<script src="../js/reports.js?v=<?php echo time()?>"></script>
<?php 
    include '../includes/footer.php';
?>