<!DOCTYPE html>
<html>
<head>
    <title>Table Manipulation</title>
    <!-- Add necessary CSS and JavaScript libraries, including jQuery -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
</head>
<body>
    <div class="container">
        <a href="javascript:void(0)" class="btn btn-secondary btn-sm" id="viewHist">View History</a>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th scope="col">Product</th>
                    <th scope="col">Price</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <th scope="row"><input type="text" class="form-control" name="product[]" placeholder="Product.." id="product"></th>
                    <td><input type="text" class="form-control" name="price[]" placeholder="Price..." id="product"></td>
                    <td>
                        <button class="btn btn-primary btn-sm add-row">Add</button>
                        <button class="btn btn-danger btn-sm remove-row">Remove</button>
                    </td>
                </tr>
            </tbody>
        </table>
        <button class="btn btn-primary" style="float: right;" id="btnSave">Save</button>
    </div>

<!-- Modal -->
<div class="modal fade" id="historyModal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">Modal title</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">


        <table class="table" id="table">
            
        </table>


      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Understood</button>
      </div>
    </div>
  </div>
</div>

    <script>
        $(document).ready(function () {
            // Add row
            var rowCounter = 1;
            $(document).on("click", ".add-row", function () {
                var newRow = '<tr>' +
                    '<th scope="row"><input type="text" name="product['+rowCounter+']" id="product" class="form-control" placeholder="Product.."></th>' +
                    '<td><input type="text" class="form-control" name="price['+rowCounter+']" id="price" placeholder="Price..."></td>' +
                    '<td>' +
                    '<button class="btn btn-primary btn-sm add-row">Add</button>' +
                    '<button class="btn btn-danger btn-sm remove-row">Remove</button>' +
                    '</td>' +
                    '</tr>';
                $("tbody").append(newRow);
                rowCounter++;
            });

            // Remove row
            $(document).on("click", ".remove-row", function () {
                if ($("tbody tr").length > 1) {
                    $(this).closest("tr").remove();
                } else {
                    Swal.fire({
                        title: "Warning",
                        text: "At least one row must remain!",
                        icon: "warning"
                    });
                }
            });
        });


        $(document).on("click","#btnSave",function(e){
            e.preventDefault();

            var formData = [];
        $("tbody tr").each(function () {
            var product = $(this).find('input[name^="product["]').val();
            var price = $(this).find('input[name^="price["]').val();
            formData.push({ product: product, price: price });
        });
        // console.log(formData);
        $.ajax({
            url: "<?php base_url()?>main/store",
            data: JSON.stringify(formData),
            type: "POST",
            dataType: "json",
            success: function(response){
                console.log(response);
            }
        })
            

        })


        $(document).on('click','#viewHist', function(){
            $("#historyModal").modal('show');

            $.ajax({
                url: "<?php base_url(); ?>main/history",
                dataType: 'json',
                type: 'POST',
                data: {},
                success: function(response){
                    console.log(response);
                    $("#table").append(response.html);
                }
            })
        });
    </script>


</body>
</html>
