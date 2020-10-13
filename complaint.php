
<html>
    <body>
       <a href='login.php' id='login'></a>
       <a href='main.php' id='main'></a>
    </body>
    <script>
    if(confirm('You need to Login First'))
    {
        document.getElementById('login').click();
    }
    else
    {
        document.getElementById('main').click();
    }
</script>
</html>
