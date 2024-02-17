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
   <ul id="list">

   </ul>
   <script>
     const host = "<?php echo getenv("BACKEND_HOST"); ?>";
     
     const port = <?php echo getenv("BACKEND_PORT"); ?>;

     console.log(`http://${host}:${port}`);
    $(document).ready(function(e) {
      $.ajax({
        url: `http://${host}:${port}`,
        method: "GET",
        success: function(data) {
          console.log(data);
          let content = '';
          data.todos.forEach((d) => {
            content += `
              <li>${d.msg}</li>
            `
          });
          $("#list").html(content);
        }
      });
    });

    $("#add").submit(function(e){
      e.preventDefault();
      


      const data = $('#add').serialize();
      $.ajax({
        url: `http://${host}:${port}`,
        data,
        method: "POST",
        success: function() {
          $.ajax({
            url: `http://${host}:${port}`,
            method: "GET",
            success: function(data) {
              console.log(data);
              let content = '';
              data.todos.forEach((d) => {
                content += `
                  <li>${d.msg}</li>
                `
              });
              $("#list").html(content);
            }
          });
        }
      });
    });
    </script>
</body>
</html>
