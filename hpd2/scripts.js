var pagenum = 0;
var perPage = 10;
var currentid = 0;
var keywords = "";

$(document).ready(function(){

    $.getScript('navbar.js', function(){
        $("#navdiv").html(navbar_html);
    });

    $.getScript('modals.js', function(){
        $("#submissionModalDiv").html(ownerSubmissionModal);
        $("#editModalDiv").html(ownerEditModal);
        $("#itemsModal").html(itemModal);
        $("#itemsSubmissionModal").html(itemSubmissionModal);
        $("#itemsEditModal").html(itemEditModal);
    });

    showOwners();
});

$(document).on("click", "#updateOwner", function(event){
    var data = {};
    $.each($('#editOwnerForm').serializeArray(), function() {
        data[this.name] = this.value;
    });
    data = JSON.stringify(data);
    console.log(data);
    $.ajax({
        url: "http://localhost/api/owner/update.php",
        type : "POST",
        contentType : 'application/json',
        data : data,
        success : function(result) {
            showOwners();
        },
        error: function(xhr, resp, text) {
            console.log(xhr, resp, text);
        }
    });
});

$(document).on("click", "#updateItem", function(event){
    var data = {};
    $.each($('#editItemForm').serializeArray(), function() {
        data[this.name] = this.value;
    });
    data = JSON.stringify(data);
    console.log(data);
    $.ajax({
        url: "http://localhost/api/item/update_item.php",
        type : "POST",
        contentType : 'application/json',
        data : data,
        success : function(result) {
            showItems(currentid);
        },
        error: function(xhr, resp, text) {
            console.log(xhr, resp, text);
        }
    });

    $("#itemEditModal").modal("toggle");
});

$(document).on("click", "#submitOwner", function(event){
    var data = {};
    $.each($('#createOwnerForm').serializeArray(), function() {
        data[this.name] = this.value;
    });
    data = JSON.stringify(data);
    console.log(data);
    console.log(JSON.parse(data));

    $.ajax({
        url: "http://localhost/api/owner/create.php",
        type : "POST",
        contentType : 'application/json',
        data : data,
        success : function(result) {
            showOwners();
        },
        error: function(xhr, resp, text) {
            console.log(xhr, resp, text);
        }
    });

    $("#ownerSubmissionModal").modal("toggle");
});


$(document).on('click', '.delete-owner', function(){
    var myid = $(this).attr('data-id');
    $.ajax({
        url: "http://localhost/api/owner/delete.php",
        type : "POST",
        dataType : 'json',
        data : JSON.stringify({ id: myid }),
        success : function(result) {

            showOwners();
        },
        error: function(xhr, resp, text) {
            console.log(xhr, resp, text);
        }
    });
});

$(document).on('click', '.delete-item', function(){
    var myid = $(this).attr('data-id');
    $.ajax({
        url: "http://localhost/api/item/delete_item.php",
        type : "POST",
        dataType : 'json',
        data : JSON.stringify({ id: myid }),
        success : function(result) {

            showItems(currentid);
        },
        error: function(xhr, resp, text) {
            console.log(xhr, resp, text);
        }
    });
});

function showOwnerSubmissionModal(){
    $("#ownerSubmissionModal").modal("show");
    }

function showOwners(){
    var pageInfo = JSON.stringify({pnum: pagenum, ppage: perPage})
    console.log(pageInfo);


        $.getJSON("http://localhost/api/owner/read.php?pagenum=" + pagenum, function(data){
            console.log(data.owners);
            var ownerTableData ="";
            $.each(data.owners, function(index, value){
                ownerTableData += "<tr>"
                ownerTableData += "<td class='ownercell' data-id='" + value.id + "'>" + value.fname + "</td>"
                ownerTableData += "<td class='ownercell' data-id='" + value.id + "'>" + value.lname + "</td>"
                ownerTableData += "<td class='ownercell' data-id='" + value.id + "'>" + value.street1 + "</td>"
                ownerTableData += "<td class='ownercell' data-id='" + value.id + "'>" + value.street2 + "</td>"
                ownerTableData += "<td class='ownercell' data-id='" + value.id + "'>" + value.city + "</td>"
                ownerTableData += "<td class='ownercell' data-id='" + value.id + "'>" + value.state + "</td>" 
                ownerTableData += "<td class='ownercell' data-id='" + value.id + "'>" + value.zip + "</td>"
                ownerTableData += "<td class='ownercell' data-id='" + value.id + "'>" + value.policy + "</td>"
                ownerTableData += "<td class='ownercell' data-id='" + value.id + "'>" + value.expiration + "</td>"
                ownerTableData += "<td><a class='btn btn-success edit-owner' href='#' role='button' data-id='" + value.id + "'>Edit</a></td>"
                ownerTableData += "<td><a class='btn btn-danger delete-owner' href='#' role='button'  data-id='" + value.id + "'>Delete</a></td>"
                ownerTableData += "</tr>"
            })
            $("#ownerTable").html(ownerTableData); 
        });

        document.getElementById('currentPageButton').innerHTML = pagenum + 1;
    }

$(document).on('click', '.ownercell', function(){
    var id = $(this).attr('data-id');
    currentid = id;
    showItems(currentid);
});

$(document).on('click', '.edit-owner', function(){
    var id = $(this).attr('data-id');
    $.when(makeNewOwnerEditModal(id)).then(openEditModal());
});

$(document).on('click', '.edit-item', function(){
    var id = $(this).attr('data-id');
    
    console.log(id);
    $.getJSON("http://localhost/api/item/read_one.php?id=" + id, function(data){
      
      document.getElementById('editItemId').value = id;
      document.getElementById('editName').value = data.name;
      document.getElementById('editPhoto').value = data.photo;
      document.getElementById('editDescription').value = data.description;
      document.getElementById('editValuation').value = data.valuation;
      document.getElementById('editMethod').value = data.method;
      document.getElementById('editVerified').value = data.verified;
      document.getElementById('editCreationDate').value = data.creationDate;
    });

    $("#itemEditModal").modal("show")
});     

function showItems(id){
    $.getJSON("http://localhost/api/item/read_items.php?ownerkey=" + id, function(data){
            var itemTableData = "";
            $.each(data.items, function(index, value){
                itemTableData += "<tr>"
                itemTableData += "<td>" + value.name + "</td>"
                itemTableData += "<td>" + value.description + "</td>"
                itemTableData += "<td>" + value.valuation + "</td>"
                itemTableData += "<td>" + value.method + "</td>"
                itemTableData += "<td>" + value.creationDate + "</td>"
                itemTableData += "<td><a class='btn btn-success edit-item' href='#' role='button' data-id='" + value.id + "'>Edit</a></td>"
                itemTableData += "<td><a class='btn btn-danger delete-item' href='#' role='button'  data-id='" + value.id + "'>Delete</a></td>"
            })
            $("#itemBody").html(itemTableData);
            $.getJSON("http://localhost/api/owner/read_one.php?id=" + id, function(data){
                var title = "<strong>" + data.fname + " " + data.lname + "</strong>";
                document.getElementById('itemModalLabel').innerHTML = title; 
            })

            $("#ownerItemsModal").modal("show");
    });

}

    $(document).on("click", "#submitItem", function(event){
        console.log("submititem");
        var data = {};
        $.each($('#createItemForm').serializeArray(), function() {
            data[this.name] = this.value;
        });
        mydata = JSON.stringify(data);
        console.log(mydata);
        console.log(JSON.parse(mydata));
        console.log(currentid);
    
        $.ajax({
            url: "http://localhost/api/item/create_item.php?ownerkey=" + currentid,
            type : "POST",
            contentType : 'application/json',
            data : mydata,
            success : function(result) {
            },
            error: function(xhr, resp, text) {
                console.log(xhr, resp, text);
            }
        });

        showItems(currentid);
        $("#itemSubmissionModal").modal("toggle")
    });


function openEditModal() {
    $("#editModal").modal("show")
}

function makeNewOwnerEditModal(id)
{
    console.log(id);
    $.getJSON("http://localhost/api/owner/read_one.php?id=" + id, function(data){
      console.log(data.state.toUpperCase());
      var title = "<strong>" + data.fname + " " + data.lname + "</strong>";
      document.getElementById('editModalLabel').innerHTML = title;
      document.getElementById('editid').value = id;
      document.getElementById('editfname').value = data.fname;
      document.getElementById('editlname').value = data.lname;
      document.getElementById('editstreet1').value = data.street1;
      document.getElementById('editstreet2').value = data.street2;
      document.getElementById('editcity').value = data.city;
      document.getElementById('editstate').value = data.state.toUpperCase();
      document.getElementById('editzip').value = data.zip;
      document.getElementById('editpolicy').value = data.policy;
      document.getElementById('editexpiration').value = data.expiration;
    });
}

$(document).on('click', '.paging-button', function(){
    var value = parseInt($(this).attr('data-value'), 10);
    
    if(pagenum + value > -1)
    {
        pagenum = pagenum + value;
    }
    console.log(pagenum);
    showOwners();
});    