<html>
  <body>
    <a href="javascript:document.inputForm.submit();">Test me</a>
    <form name="inputForm" action="pageRes.php" method="get">
      <input type="hidden" name="q" value="15" />
      <input type="image" value="2" onclick="javascript:document.inputForm.submit();" name="image" src="../images/fiches.png" />
    </form>
  </body>
</html>