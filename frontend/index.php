<!DOCTYPE html>
<html lang="en">
<head>
   <title>Todo List</title>
   <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
</head>
<body>
   <h1>To Do List</h1>
    <?php
           echo '
           <form id="add" action="" method="post">
            <input type="text" name="msg" id="">
            <button type="submit">Remind Me!</button>
           </form>
           ';
    ?>
   <ul>
       <?php
           $host = getenv("BACKEND_HOST");
           $port = getenv("BACKEND_PORT");
           $json = file_get_contents('http://'.$host.':'.$port.'/');
           $obj = json_decode($json);
           $todos = $obj->todos;
           foreach ($todos as $todo){
               echo "<li>$todo->msg</li>";
           }
       ?>
   </ul>
   <script>
    $("#add").submit(function(e){
      e.preventDefault()
      const host = "<?php echo getenv("BACKEND_HOST"); ?>"

      const port = <?php echo getenv("BACKEND_PORT"); ?>


      const data = $('#add').serialize();
      $.ajax({
        url: `http://${host}:${port}`,
        data,
        method: "POST",
        success: function() {
          window.location = window.location
        }
      })
    })
    </script>
</body>
</html>
