<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>PHP & Ajax CRUD</title>
  <link rel="stylesheet" href="css/style.css">
</head>
<body>
  <table id="main" border="0" cellspacing="0">
    <tr>
      <td id="header">
        <h1>PHP & Ajax CRUD</h1>

        <div id="search-bar">
          <label>Search :</label>
          <input type="text" id="search" autocomplete="off">
        </div>
      </td>
    </tr>
    <tr>
      <td id="table-form">
        <form id="addForm">
          First Name : <input type="text" id="fname">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
          Last Name : <input type="text" id="lname">
          <input type="submit" id="save-button" value="Save">
        </form>
      </td>
    </tr>
    <tr>
      <td id="table-data">
      </td>
    </tr>
  </table>
  <div id="pagination">
  <a class="active" id="1">1</a>
  </div>
  
  <div id="error-message"></div>
  <div id="success-message"></div>
  <div id="modal">
    <div id="modal-form">
      <h2>Edit Form</h2>
      <table cellpadding="10px" width="100%">
      </table>
      <div id="close-btn">X</div>
    </div>
  </div>

<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript">
  $(document).ready(function()
  {// load data
    function load()
    {
      $.ajax(
      {
        url:'ajax-load.php',
        type:'POST',
        success:function(data)
        {
          $("#table-data").html(data);
        }
      });
    }
    load();
    // insert data
    $("#save-button").on("click",function(e)
    {
      e.preventDefault();
      var f_name = $("#fname").val() ;
      var l_name = $("#lname").val();

      if(f_name == "" || l_name == "")
      {
        $("#error-message").html("All Fields are required").slideDown();
        $("#success-message").slideUp();
      }
      else
      {
        $.ajax(
      { 
          url:'ajax-insert.php',
          type:'POST',
          data:{first_name:f_name,last_name:l_name},
          success:function(data)
          {
            if(data)
            {
              load();
              $("#addForm").trigger("reset");
              $("#success-message").html("Form Submited Successfully").slideDown();
              $("#error-message ").slideUp();

            }
            else
            {
              $("#error-message").html("Can't save the data").slideDown();
              $("#success-message").slideUp();
            }
          }
      }
      );

      }

      
    });
    // delete data
    $(document).on("click",".delete-btn",function()
    {
      var get_id = $(this).data("id");
      var element = this;
      if(confirm("Do you really want to delete this data"))
      {
        $.ajax(
        {
          url:"ajax-delete.php",
          type:"POST",
          data:{Id_pass:get_id},
          success:function(data)
          {
            if(data)
            {
             $(element).closest("tr").fadeOut();
              $("#success-message").html("Deleted successfully").slideDown();
              $("#error-message ").slideUp();

            }
            else
            {
              $("#error-message").html("Can't delete the data").slideDown();
              $("#success-message").slideUp();
            }
          }

        }
      ); 
      }
      
    });
    $("#close-btn").on("click",function()
    {
      $("#modal").hide();
    });
    $(document).on("click",".edit-btn",function()
    {
      $("#modal").show();
      var f_name = $(this).data("eid");
      $.ajax(
        {
          url:"load-update-form.php",
          type:"POST",
          data:{first_name:f_name},
          success:function(data)
          { 
            $("#modal-form table").html(data);
          }
        }
      );
    });
    // edit-submit button

    $(document).on("click","#edit-submit",function()
    {

      var first_name = $("#edit-fname").val();
      var Last_name = $("#edit-lname").val();
      var Id = $("#edit-id").val();

      $.ajax(
        {
          url:"ajax-update-form.php",
          type:"POST",
          data:{f_name:first_name,l_name:Last_name,id:Id},
          success:function(data)
          {
            $("#modal").hide();
            load();
          }
        }
      );


    });

    $("#search").on("keyup",function()
    {
      var search = $(this).val();
      $.ajax(
        {
          url:"ajax-live-search.php",
          type:"POST",
          data:{Search_term:search},
          success:function(data)
          {
            $("#table-data").html(data);
          }
        }
      );
    });



  });
</script>
</body>
</html>
