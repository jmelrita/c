<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <title>BOOKS</title>
</head>
<style>
    label{
        width:100px;
    }
    button{
        width:200px;
        height:50px;
    }
</style>
<?php
    $con=mysqli_connect("localhost","root","","books");
    $prompt="";
    $isb="";
    $Title="";
    $Copyright="";
    $Edition="";
    $Price="";
    $Quantity="";
    if($con){
        if(isset($_GET['add'])){
            $isbn=$_GET['isbn'];
            $title=$_GET['title'];
            $copyright=$_GET['copyright'];
            $edition=$_GET['edition'];
            $price=$_GET['price'];
            $qty=$_GET['quantity'];
            $sql="SELECT * FROM books WHERE ISBN='$isbn'";
            $res=mysqli_query($con,$sql);
            if(mysqli_num_rows($res)>0){
                $prompt="RECORD ALREADY EXIST";
            }else{
                if($isbn==""){
                    $prompt="NO RECORD TO ADD";
                }
                else{
                    $sql="INSERT INTO books(ISBN,Title,Copyright,Edition,Price,Quantity) VALUES('$isbn','$title','$copyright','$edition','$price','$qty')";
                    $res=mysqli_query($con,$sql);
                    $prompt="RECORD SUCCESSFULLY SAVED"; 
                }
            }
        }
        if(isset($_GET['search'])){     
            $isbn=$_GET['isbn'];
            $sql="SELECT * FROM books WHERE ISBN='$isbn'";
            $res=mysqli_query($con,$sql);
            if(mysqli_num_rows($res)>0){
                while($row=mysqli_fetch_assoc($res)){
                    $isb=$row['ISBN'];
                    $Title=$row['Title'];
                    $Copyright=$row['Copyright'];
                    $Edition=$row['Edition'];
                    $Price=$row['Price'];
                    $Quantity=$row['Quantity'];
                    $prompt="ITEM IS FOUND";
                }
            }else{
                $prompt="ITEM NOT FOUND";
            }
        }
        if(isset($_GET['edit'])){
            $isbn=$_GET['isbn'];
            $title=$_GET['title'];
            $copyright=$_GET['copyright'];
            $edition=$_GET['edition'];
            $price=$_GET['price'];
            $qty=$_GET['quantity'];
            $sql="SELECT * FROM books WHERE ISBN='$isbn'";
            $res=mysqli_query($con, $sql);
            if(mysqli_num_rows($res)>0){
                $sql="UPDATE books SET Title='$title', Copyright='$copyright', Edition='$edition', Price='$price', Quantity='$qty' WHERE ISBN='$isbn'";
                $res=mysqli_query($con, $sql);
                $prompt="RECORD SUCCESSFULLY UPDATED";
            }else{$prompt="ISBN# IS NOT FOUND";}
        }
        if(isset($_GET['delete'])){
            $isbn=$_GET['isbn'];
            $sql="SELECT * FROM books WHERE ISBN='$isbn'";
            $res=mysqli_query($con, $sql);
            if(mysqli_num_rows($res)>0){
                $sql="DELETE FROM books WHERE ISBN='$isbn'";
                $res=mysqli_query($con, $sql);
                $prompt="RECORD SUCCESSFULLY DELETED";
            }else{$prompt="ISBN# IS NOT FOUND";}
            
        }
        
    }else {$prompt="Not Connected";}
?>
<body>
    <div class="row" style="margin: 2%;">
        <div class="col-lg-6" style="border-style: groove; width: 50%; height: 500px; padding:20px;">
            <form method="GET" action=''>
                <label>ISBN#:</label>
                <input type="text" name="isbn" value="<?php echo $isb;?>"></input><br><br>
                <label>Title:</label>
                <input type="text" name="title" value="<?php echo $Title;?>"></input></input><br><br>
                <label>Copyright:</label>
                <input type="text" name="copyright" value="<?php echo $Copyright;?>"></input></input><br><br>
                <label>Edition:</label>
                <input type="text" name="edition"value="<?php echo $Edition;?>"></input></input><br><br>
                <label>Price:</label>
                <input type="text" name="price" value="<?php echo $Price;?>"></input></input><br><br>
                <label>Quantity:</label>
                <input type="number" id="quantity" name="quantity" value="<?php echo $Quantity;?>"></input></input><br><br>
            
        </div>
        <div class="col-lg-4" style=" width: 50%; height: 500px;">
            <button class="btn btn-primary" type='submit' name='search'>SEARCH</button>
            <button class="btn btn-primary" type='submit' name='edit'>EDIT</button><br><br>
            <button class="btn btn-danger" type='submit' name='delete' onclick="return confirm('Are you sure you want to delete?')">DELETE</button>
            <button class="btn btn-primary" type='submit' name='add'>ADD</button><br><br>
            <div class="col-lg-6" style="border-style: groove; width: 50%; height: 300px; padding:20px;">
                <?php echo $prompt;?>
            </div>
        </div>
        </form>
    </div>
    <div style="margin:20px;">
        <table class="table table-bordered">
            <thead style="background-color:gray;">
            <tr>
                <th>ISBN</th>
                <th>Title</th>
                <th>Copyright</th>
                <th>Edition</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>TOTAL</th>
            </tr>
            </thead>
            <tbody>
                <?php
                $totalSum = 0;
                $qtySum = 0;
                    if($con){
                        $sql="SELECT * FROM books";
                        $res=mysqli_query($con,$sql);
                        if(mysqli_num_rows($res)>0){
                            while($row=mysqli_fetch_assoc($res)){
                                echo "<tr>";
                                    echo "<td>$row[ISBN]</td>";
                                    echo "<td>$row[Title]</td>";
                                    echo "<td>$row[Copyright]</td>";
                                    echo "<td>$row[Edition]</td>";
                                    echo "<td>$row[Price]</td>";
                                    echo "<td>$row[Quantity]</td>";
                                    $price=$row["Price"];
                                    $qty=$row["Quantity"];
                                    $total=(int)$price*(int)$qty;
                                    echo "<td>$total</td>";
                                    $totalSum += $total;
                                    $qtySum += $qty;
                                echo "</tr>";
                            }
                        }
                    }else {$prompt="Not Connected";}
                
                ?>
                <td colspan="5"></td>
                <th><?php echo $qtySum; ?></th>
                <th><?php echo $totalSum; ?></th>
                
            </tbody>

        </table>
            

        
    </div>  
</body>
</html>
