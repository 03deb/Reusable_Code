<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <title>Order List</title>
    <style>
        #docsheading {
            margin-top: 2px;
            height: 50px;
            width: 347px;
        }
        #dochead {
            font-size: 20px;
            margin-top: 10px;
            margin-left: 12px;
            font-family: Arial, sans-serif;
            font-weight: 600;
        }
        #ord-lst {
            font-size: 17px;
            margin-top: 10px;
            margin-left: 6px;
            font-family: Arial, sans-serif;
            font-weight: 600;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>
<div id="docsheading"><label id="dochead">Order List</label></div>
<form id="orderForm" method="post" enctype="multipart/form-data" action="upload.php">
    <label id="ord-lst">Order Id &nbsp;</label>
    <input type="text" name="order_id" id="order_id" placeholder="Enter Order Id" required>
    <input type="hidden" name="total_fields" id="total_fields" value="1">
    <table class="table">
        <thead>
            <tr>
                <th scope="col">Actions</th>
                <th scope="col">Order Name</th>
                <th scope="col">Description</th>
                <th scope="col">Upload File</th>
            </tr>
        </thead>
        <tbody id="orderTableBody">
            <tr id="row1">
                <td>
                    <button type="button" name="add" id="add" class="btn btn-success"><i class="fa fa-plus"></i></button>
                </td>
                <td><input type="text" name="order_name[]" placeholder="Enter Unique File Name" required></td>
                <td><input type="text" name="description[]" placeholder="Enter File Description" maxlength="50" required></td>
                <td><input type="file" name="files[0][]" multiple></td>
                <td><input type="hidden" name="unique_id[]" value="unique_1"></td>
            </tr>
        </tbody>
    </table>
    <button type="submit" class="btn btn-primary">Submit</button>
</form>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    var i = 1;
    $('#add').click(function() {
        var uniqueId = 'unique_' + i;
        $('#orderTableBody').append(
            "<tr id='row" + i + "'>" +
            "<td><button type='button' name='remove' id='" + i + "' class='btn btn-danger btn_remove'><i class='fa fa-trash'></i></button></td>" +
            "<td><input type='text' name='order_name[]' placeholder='Enter Unique File Name' required></td>" +
            "<td><input type='text' name='description[]' placeholder='Enter File Description' maxlength='50' required></td>" +
            "<td><input type='file' name='files[" + i + "][]' multiple ></td>" +
            "<td><input type='hidden' name='unique_id[]' value='" + uniqueId + "'></td>" +
            "</tr>"
        );
        i++;
        $('#total_fields').val(i);
    });

    $(document).on('click', '.btn_remove', function() {
        var button_id = $(this).attr("id");
        $('#row' + button_id).remove();
        i--;
        $('#total_fields').val(i);
    });
});
</script>
</body>
</html>