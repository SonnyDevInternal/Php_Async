<html>
    <head></head>
    <body>

    <h1>Async Basics</h1>

    <h2>Register User</h2>
    <form method="post" action="user.php">
        <label>Name</label> <input type="text" name="username">
        <label>Password</label> <input type="password" name="password">
        <input type="submit">
    </form>
   
    <div id="container"></div>

   <?php 
    // AJAX
    // Asynchronous Javascript and XML
    ?>

    <script>

        function RefreshUser() {
            let container = document.getElementById("container");
            let xmlHTTP = new XMLHttpRequest();
            xmlHTTP.onreadystatechange = function(){
                if(this.readyState == 4 && this.status == 200){
                    container.innerHTML = this.responseText;
                }
            }
            xmlHTTP.open("GET", "getuser.php", true);
            xmlHTTP.send();
        }

        function DeleteUser(id){
            let xmlHTTP = new XMLHttpRequest();
            xmlHTTP.onreadystatechange = function(){
                if(this.readyState == 4 && this.status == 200){
                    console.log(this.responseText);
                    RefreshUser();
                }
            }
            xmlHTTP.open("DELETE", "deleteuser.php?id="+id, true);
            xmlHTTP.send();
        }

        RefreshUser();

        setInterval(() => {
            RefreshUser();
        },10000);

    </script>
    </body>
</html>