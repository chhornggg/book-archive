<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>  
    <div class="w-1/2 mx-auto bg-slate-400 rounded-lg mt-12 py-4">
    <h1 class="text-4xl text-center font-bold mb-4">BOOK ARCHIVE</h1>
    <hr>
    <form action="display.php" method="get" class="ml-52 mt-4">
        
        <div class="mb-4">
            <label class="font-medium">Code </label>
            <input type="text" name="code" class="bg-slate-200 ml-16 p-1 rounded-md"/>
        </div>
        <div class="mb-4">
            <label class="font-medium">Book Name </label>
            <input type="text" name="name" class="bg-slate-200 ml-5 p-1 rounded-md"/>
        </div>
        <div class="mb-8">
            <label class="font-medium">Author </label>
            <input type="text" name="author" class="bg-slate-200 ml-14 p-1 rounded-md"/>
        </div>
        <input type="submit" name="add" value="Add" class="mb-6 ml-2 w-80 text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-3 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
    </form>
    </div>
    
    <div class="flex flex-col w-1/2 mx-auto mt-8">
  <div class="-m-1.5 overflow-x-auto">
    <div class="p-1.5 min-w-full inline-block align-middle">
      <div class="border overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
          <thead>
            <tr>
              <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">Code</th>
              <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">Book Name</th>
              <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">Author</th>
              <th scope="col" class="px-6 py-3 text-end text-xs font-medium text-gray-500 uppercase">Action</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-gray-200">

            <?php 
                $cn = new mysqli("localhost", "root", null, "test");

                if(isset($_GET['add'])) {
                    $code = $_GET['code'];
                    $author = $_GET['author'];
                    $name = $_GET['name'];

                    $update = "UPDATE Book SET Code = '$code', Name = '$name', Author = '$author' WHERE Name = '$name'";

                    $add = "INSERT INTO Book (Code, Name, Author) VALUES ('$code', '$name', '$author')";

                    $checkBookName = $cn->query("SELECT * FROM Book WHERE Name = '$name'");
                    
                    if($checkBookName->num_rows > 0) {
                        if($cn->query($update) == true) {
                            header("Location: /book-archive/display.php");
                            echo "Updating data successfully.";
                        } else echo "Cannot update data " . $cn->error;
                    } else {
                        if($cn->query($add) == true) {
                            header("Location: /book-archive/display.php");
                            echo "Adding data successfully.";
                        } else echo "Cannot insert data " . $cn->error;
                    }

                }

                if(isset($_GET['dcode'])) {
                    $delete_code = $_GET['dcode'];
            
                    $delete = "DELETE FROM Book WHERE Code = '$delete_code'";
            
                    if($cn->query($delete) == true) {
                        header("Location: /book-archive/display.php");
                    } else {
                        echo "Failed to delete " . $cn->error;
                    }
                }

                $select = $cn->query("SELECT * FROM Book");

                if($select->num_rows > 0) {
                    while($book = $select->fetch_assoc()) {
                        echo "
                            <tr>
                            <td class='px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800'>$book[Code]</td>
                            <td class='px-6 py-4 whitespace-nowrap text-sm text-gray-800'>$book[Name]</td>
                            <td class='px-6 py-4 whitespace-nowrap text-sm text-gray-800'>$book[Author]</td>
                            <td class='px-6 py-4 whitespace-nowrap text-end text-sm font-medium'>
                            <a href='display.php?dcode=$book[Code]' class='inline-flex items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent text-blue-600 hover:text-blue-800 disabled:opacity-50 disabled:pointer-events-none'>Delete</a>
                            </td>
                        </tr>
                        ";
                    }
                }

                

                $cn->close();
            ?>
            
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
</body>
</html>