<?php
    include_once "hf/artist_header.php";
    if (!isset($_SESSION["username"])) {
        header("location: index.php?error=unauthorized");
        exit();
    }
    if (!isset($_SESSION["userType"]) || ($_SESSION["userType"] != "Artist")){
        header("location: index.php?error=unauthorized");
        exit();
    }
?>
    <div class='container'>
        <h1 class="display-2 text-center">My Songs</h1>
        <table 
        class="table"
        data-toggle="table"
        id="table"
        data-pagination="true"
        data-search="true"
        data-use-row-attr-func="false"
        data-reorderable-rows="false"
        data-url="includes/get_songs_of_artist.inc.php">
            <thead>
                <tr>
                    <th data-field="music_object_id" data-sortable="true" searchable="false">ID</th>
                    <th data-field="name" data-sortable="true">Name</th>
                    <th data-field="price" data-sortable="true" searchable="false">Price</th>
                    <th data-field="length" data-sortable="true" searchable="false">Length</th>
                    <th data-field="genre_name" data-sortable="false">Genre</th>
                    <th data-field="score" data-sortable="true" searchable="false">Score</th>
                    <th data-field="release_date" data-sortable="true">Release Date</th>
                    <th data-field="cover_img" data-sortable="false" searchable="false">Cover</th>
                </tr>   
            </thead>
        </table>
    </div>

<?php
    include_once "hf/artist_footer.php";
?>