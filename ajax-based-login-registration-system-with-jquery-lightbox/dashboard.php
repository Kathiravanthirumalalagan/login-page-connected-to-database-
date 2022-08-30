<div class="dashboard">
    <?php
    if (isset($_SESSION['username'])) {
        echo "Welcome  " . $_SESSION['username'] ;
                ?>
        
        <?php
    }
    ?>
    <?php
    if (isset($_SESSION['regno'])) {
        echo "<br>". $_SESSION['regno'];
                ?>
                
        <?php
    }
    ?>
    <?php
    if (isset($_SESSION['email'])) {
        echo "<br>" . $_SESSION['email'] ;
                ?>
                <div style="height: 10px"></div>
                <div>
                    <a href="logout.php"><input type="button" class="btn-logout"
                        value="Logout"></a>
            
                </div>

        <?php
    }
    ?>
</div>
<?php
echo "THANK YOU FOR CHOOSING GUVI";
?>
