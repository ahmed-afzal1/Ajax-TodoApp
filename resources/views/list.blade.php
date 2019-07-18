<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Ajax ToDo App</title>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">

    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
</head>
<body>
    <br>
   <div class="container">
       <div class="row">
           <div class="col-lg-offset-3 col-lg-6">
            <div class="card bg-danger mb-3" id="items" style="max-width: 36rem;">
                <div class="card-header">
                  <b>Ajax ToDo App</b>
                  <a href="#" id="addNew" class="pull-right" style="color:black"  data-toggle="modal" data-target="#exampleModal">
                    <i class="fa fa-plus" aria-hidden="true"></i>
                  </a>
                </div>
                <div class="card-body">
                    <ul class="list-group">
                      @foreach ($items as $item)
                      <li class="list-group-item ourItem" data-toggle="modal" data-target="#exampleModal">{{$item->item}}
                      
                          <input type="hidden" id="itemId" value="{{$item->id}}">
                      </li>
                      
                      @endforeach
                        
                    </ul>
                </div>
              </div>
           </div>
       </div>

       <div class="modal" tabindex="-1" role="dialog" id="exampleModal">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="title">Add New Item</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <input type="hidden" id="id">
                  <input type="text" placeholder="write item here" class="form-control" id="addItem">
                </div>
                <div class="modal-footer">
                  
                    <button type="button" class="btn btn-danger" id="delete" style="display:none;" data-dismiss="modal">Delete</button>
                  <button type="button" id="saveChange" class="btn btn-primary" style="display:none;" data-dismiss="modal">Save changes</button>

                  <button type="button" class="btn btn-primary" id="addButton" data-dismiss="modal">Add Item</button>
                </div>
              </div>
            </div>
          </div>
   </div>

    


{{ csrf_field() }}

<!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

<!-- Popper JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>

<!-- Latest compiled JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

<script>
  $(document).ready(function(){
    $(document).on('click','.ourItem',function(){
      var text = $(this).text();
      var id = $(this).find('#itemId').val();
      $("#title").text("Edit Item");
      $("#addItem").val(text);
      $("#delete").show('100');
      $("#saveChange").show('100');
      $("#addButton").hide('100');
      $("#id").val(id);
    });
    $("#addNew").click(function(){
      $("#title").text("Add New Item");
      $("#addItem").val("");
      $("#delete").hide('100');
      $("#saveChange").hide('100');
      $("#addButton").show('100');
    });
    $("#addButton").click(function(){
      var text = $("#addItem").val();
      $.post('list',{'text':text,'_token':$('input[name=_token]').val()},function(data){
        console.log(data);
        $("#items").load(location.href+' #items');
      });
      
    });
    $(document).on('click','#delete',function(){
      var id = $('#id').val();
      $.post('delete',{'id':id,'_token':$('input[name=_token]').val()},function(){
        $("#items").load(location.href+' #items');
        console.log(id);
      });
    });

    $(document).on('click','#saveChange',function(){
      var id = $('#id').val();
      var value = $('#addItem').val();
      $.post('update',{'id':id,'value':value,'_token':$('input[name=_token]').val()},function(data){
         $("#items").load(location.href+' #items');
        console.log(data);
      });
    });
  });
</script>


</body>
</html>