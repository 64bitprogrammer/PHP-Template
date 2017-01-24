<?php
require_once('connect.php');
$row = mysqli_fetch_assoc(mysqli_query($conn,"select count(*) as count from tbl_register"));
$cnt = $row['count'];

?>
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
	<div align="center" id="content">
    <!-- <table border="1">
      <tr>
        <th> First Name </th>
        <th> Last Name </th>
        <th> Gender </th>
        <th> DOB </th>
        <th> Email </th>
      </tr>
    </table> -->
  </div>
  <br><br>
  <div align="center" id="pagination_space">
  </div>
</body>
<script>
  var prev, next;
  var i=0,page=1;
  var recordsPerPage = 5;
  var currentPage = 1;
  var totalRecords = <?= $cnt ?>;
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
      currentPage = 1;
      paginate();
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
          $("#content").html("");
          var body = document.getElementById('content');
          var tbl = document.createElement('table');
          tbl.style.width = '100%';
          tbl.setAttribute('border', '1');
          var thead = document.createElement('thead');
          var tr = document.createElement('tr');
          var th = document.createElement('th');
          th.setAttribute('width', '5%');
          th.appendChild(document.createTextNode("First Name"))
          tr.appendChild(th);
          thead.appendChild(tr);

          var th = document.createElement('th');
          th.setAttribute('width', '5%');
          th.appendChild(document.createTextNode("Last Name"))
          tr.appendChild(th);
          thead.appendChild(tr);

          var th = document.createElement('th');
          th.setAttribute('width', '5%');
          th.appendChild(document.createTextNode("Email"))
          tr.appendChild(th);
          thead.appendChild(tr);

          var th = document.createElement('th');
          th.setAttribute('width', '5%');
          th.appendChild(document.createTextNode("DOB"))
          tr.appendChild(th);
          thead.appendChild(tr);

          var th = document.createElement('th');
          th.setAttribute('width', '5%');
          th.appendChild(document.createTextNode("Gender"))
          tr.appendChild(th);
          thead.appendChild(tr);

          tbl.appendChild(thead);

          var tbdy = document.createElement('tbody');
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

            tbdy.appendChild(tr);
					}
          tbl.appendChild(tbdy);
          body.appendChild(tbl)

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
