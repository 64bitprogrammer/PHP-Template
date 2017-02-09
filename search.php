<html>
<head>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
  <style>
  </style>
</head>
<body style="background-color:#CCCCCC;">
  <div class="form" align="center">
    <input type="text" id="searchbox" />
    <button id="searchbtn">Search</button> <br><br>
  </div>
  <div class="table" style="height:40%">
  <table border="1" width="100%" style="height:100%">
    <thead>
      <tr style="height:40px">
        <th style="width:20%"> First Name </th>
        <th style="width:20%"> Last Name </th>
        <th style="width:25%"> Email </th>
        <th style="width:20%"> DOB </th>
        <th style="width:15%"> Gender </th>
      </tr>
    </thead>
    <tbody id="tbody">
    </tbody>
  </table>
</div>
  <br><br>
  <div align="center" id="pagination_space">
  </div>
</body>
<script>
var i=0;
var recordsPerPage = 5;
var currentPage = 1;
var totalRecords =0;
var totalPages = Math.ceil(totalRecords / recordsPerPage);
var pgnate = "";

function paginate(){
  pgnate = "";
  totalPages = Math.ceil(totalRecords/recordsPerPage);
  //alert("tp="+totalPages+"totalRecords="+totalRecords+"recpp="+recordsPerPage);
  for(i=1;i<=totalPages;i++){
    if(totalPages>1 && i==1){
      pgnate = "<button onclick='prevPage();'>Prev</button>";
    }
    if(i==currentPage)
    var btnStatus = "disabled";
    else
    var btnStatus = "";

    pgnate += "<button onclick='changePage("+i+");'>"+i+"</button>";

    if(totalPages >1 && i==totalPages){
      pgnate += "<button onclick='nextPage()'>Next</button>";
    }
  }
  document.getElementById("pagination_space").innerHTML = pgnate;
}

function prevPage(){
  if(currentPage>1)
  currentPage = currentPage - 1;
  else
  currentPage = 1;
  var key = $("#searchbox").val();
  var offset = ( currentPage * recordsPerPage ) - recordsPerPage;
  callMe(key,offset);
}

function nextPage(){

  if(currentPage<totalPages)
  currentPage = currentPage + 1;
  else
  currentPage = totalPages;
  var key = $("#searchbox").val();
  var offset = ( currentPage * recordsPerPage ) - recordsPerPage;
  callMe(key,offset);
}

function changePage(pg){
  var k = $("#searchbox").val();
  currentPage = pg;
  var key = $("#searchbox").val();
  var offset = ( currentPage * recordsPerPage ) - recordsPerPage;
  callMe(key,offset);
}



$(document).ready(function(){
  callMe("",0);
  $("#searchbtn").click(function(){
    var key = $("#searchbox").val();
    var offset = ( currentPage * recordsPerPage ) - recordsPerPage;
    callMe(key,offset);
    paginate();
    changePage(1);
  });
});

function callMe(ky,off){
  jQuery.ajax({
    url: "listingAPI.php",
    data:{keyword:ky,cp:currentPage,offst:off},
    type: "POST",
    success:function(data){
      var myObj = JSON.parse(data);
      var obj = JSON.stringify(myObj,null,2);
      totalRecords = Number(myObj.cnt);
      paginate();
      if(myObj.msg =="success"){
        $("#tbody").html("");
        var tbd = document.getElementById('tbody');
        var size = Object.keys(myObj).length;
        for (var i=0;i<size-2;i++){
          var tr = document.createElement('tr');
          var td = document.createElement('td');
          td.appendChild(document.createTextNode(myObj[i]['fname']))
          tr.appendChild(td)
          var td = document.createElement('td');
          td.appendChild(document.createTextNode(myObj[i]['lname']))
          tr.appendChild(td)
          var td = document.createElement('td');
          td.appendChild(document.createTextNode(myObj[i]['email']))
          tr.appendChild(td)
          var td = document.createElement('td');
          td.appendChild(document.createTextNode(myObj[i]['dob']))
          tr.appendChild(td)
          var td = document.createElement('td');
          td.appendChild(document.createTextNode(myObj[i]['gender']))
          tr.appendChild(td)
          document.getElementById('tbody').appendChild(tr);
        }
      }
      else
      $("#content").html("Error");
    },
    error:function (){
    }
  });
}
</script>
</html>
