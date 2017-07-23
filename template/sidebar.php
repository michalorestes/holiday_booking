<h1>Search</h1>
<form id="searchForm" action="index.php" method="get">
    <fieldset>
        <input id="txtSearch" type="text"   name="txtSearch" value="" /><input id="btnSearch" type="submit" value="Search" name="btnSearch" />
    </fieldset>
	<ul class="sidebar">
		<li class="ulHeader">Type</li>
        <li class="ulHeader"><input type="radio" name="radioType" value="" />All</li>
		<li class="ulHeader"><input type="radio" name="radioType" value="Flat" />Flat</li>
		<li class="ulHeader"><input type="radio" name="radioType" value="Appartment" />Appartment</li>
		<li class="ulHeader"><input type="radio" name="radioType" value="Villa" />Villa</li>
	</ul>	
	<ul class="sidebar">
		<li class="ulHeader">Area</li>
        <li class="ulHeader"><input type="radio" name="radioArea" value="" />All</li>
		<li class="ulHeader"><input type="radio" name="radioArea" value="Preston Park" />Preston Park</li>
		<li class="ulHeader"><input type="radio" name="radioArea" value="Kemptown" />Kemptown</li>
		<li class="ulHeader"><input type="radio" name="radioArea" value="Marina" />Marina</li>
	</ul>
	<ul class="sidebar">
		<li class="ulHeader">Bedrooms</li>
        <li class="ulHeader"><input type="radio" name="radioBeds" value="" />All</li>
		<li class="ulHeader"><input type="radio" name="radioBeds" value="1" />1</li>
		<li class="ulHeader"><input type="radio" name="radioBeds" value="2" />2</li>
		<li class="ulHeader"><input type="radio" name="radioBeds" value="3" />3</li>
		<li class="ulHeader"><input type="radio" name="radioBeds" value="4" />4</li>
		<li class="ulHeader"><input type="radio" name="radioBeds" value="5" />5</li>
	</ul>

    <fieldset>
        <br />
        <input id="resetFilter" type="submit" name="resetFilter" value="Reset Filter" /> <input id="btnFilterSearch" type="submit" name="filterResults" value="Filter" />   
    </fieldset>
	

</form>