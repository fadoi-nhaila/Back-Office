function setSearch(column, value, url)
{
    $(".column-"+column+" input").val(value);
    $(".column-"+column+" a.dropdown-toggle").addClass("text-yellow");
    $(".column-"+column+" a.column-filter-all").attr("href",url);
}