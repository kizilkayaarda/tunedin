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
    <script>

        data = Cookies.get("data");
        if (data === undefined) {
            data = {"songs": []};
            Cookies.set("data", JSON.stringify(data));
        } else {
            data = JSON.parse(Cookies.get("data"));
        }
        console.log(data);
        
        function formSubmit() {
            song_data = { 
                "name": document.getElementById('name').value,
                "price": document.getElementById('price').value,
                "length": document.getElementById('length').value,
                "genre_name": document.getElementById('genre').value,
                "score": document.getElementById('score').value,
                "release_date": document.getElementById('releaseDate').value,
                "cover_img": document.getElementById('coverImage').value
            };
            data = JSON.parse(Cookies.get("data"));
            data["songs"].push(song_data);
            Cookies.set("data", JSON.stringify(data));
        }

        function getAlbumOrder() {
            var table = document.getElementById('table');
            var array = [];
            var index = 0;
            
            for (i = 1; i < table.rows.length; i++) {
                song_name = table.rows[i].cells[0].innerHTML; 
                for (j = 0; j < data['songs'].length; j++) {
                    if (song_name === data['songs'][j]['name']) {
                        index = j;
                        break;
                    }
                }
                array.push(index);
            }
            return array;
        }

        function finalizeAlbum() {
            album_data = { 
                "name": document.getElementById('albumName').value,
                "cover_img": document.getElementById('albumCoverImage').value
            };
            
            data = JSON.parse(Cookies.get("data"));
            data["album"] = album_data;
            Cookies.set("data", JSON.stringify(data));
            song_order = getAlbumOrder();
            
            var xhr = new XMLHttpRequest(); 
            xhr.open('POST', 'includes/finalize_album.inc.php', true); 
            xhr.onload = function () { 
                Cookies.remove("data");
                window.location.href = "artist_homepage.php";
            } 
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded; charset=UTF-8');
            post_data = "order="+song_order; 
            xhr.send(post_data); 
        }
    </script>

    <form class="custom-form my-3" onsubmit="finalizeAlbum();" method="post">
        <h4>Album details</h4>
        <!-- Row for name and cover image link input -->
        <div class="form-row">
            <div class="col-md-6 mb-3">
                <label for="albumName">Name</label>
                <input required type="text" class="form-control" name="albumName" id="albumName" placeholder="Album name">
            </div>
            <div class="col-md-6 mb-3">
                <label for="albumCoverImage">Cover Image</label>
                <input type="url" class="form-control" name="albumCoverImage" id="albumCoverImage" placeholder="Image link">
            </div>
        </div>
        <div class="text-right my-1">
            <button type="submit" name="submit" class="btn btn-primary my-3">Finalize Album</button>
        </div>
    </form>

    <!-- Song Upload Form -->
    <!-- <form class="custom-form my-5" action="includes/uploadsong.inc.php" method="post"> -->
    <form class="custom-form my-3" onsubmit="formSubmit();">
        <h4>Upload a song to this album</h4>

        <!-- Row for name input -->
        <div class="form-row">
            <div class="col-md mb-3">
                <label for="name">Name</label>
                <input required type="text" class="form-control" name="name" id="name" placeholder="Song name">
            </div>
        </div>

        <!-- Row for price & length inputs -->
        <div class="form-row">
            <div class="col-md-6 mb-3">
                <label for="price">Price</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">$</span>
                        </div>
                    <input required type="number" class="form-control" name="price" id="price" min=0 max=999.99 step="0.01">
                </div>            
            </div>
            <div class="col-md-6 mb-3">
                <label for="length">Length (seconds) </label>
                <input required type="number" class="form-control" id="length" name="length" placeholder="Length (seconds)" min=0 max=99999999999 step=1>
            </div>
        </div>

        <!-- Row for genre & score inputs -->
        <div class="form-row">
            <div class="col-md-6 mb-3">
                <label for="genre">Genre</label>
                <select required class="custom-select" id="genre" name="genre">
                    <option selected disabled value="">Choose...</option>
                    <option value="Classical">Classical</option>
                    <option value="Country">Country</option>
                    <option value="Electronic Dance">Electronic Dance</option>
                    <option value="Hip-hop">Hip-hop</option>
                    <option value="Indie">Indie</option>
                    <option value="Jazz">Jazz</option>
                    <option value="K-pop">K-pop</option>
                    <option value="Metal">Metal</option>
                    <option value="Oldies">Oldies</option>
                    <option value="Pop">Pop</option>
                    <option value="Rap">Rap</option>
                    <option value="Rythm & Blues">Rythm & Blues</option>
                    <option value="Rock">Rock</option>
                    <option value="Techno">Techno</option>
                </select>
            </div>
            <div class="col-md-6 mb-3">
                <label for="score">Score</label>
                <input required type="number" class="form-control" id="score" name="score" placeholder="Score" min=0 max=10.9 step="0.1">
            </div>
        </div>

        <!-- Row for release date and cover image link inputs -->
        <div class="form-row">
            <div class="col-md-6 mb-3">
                <label for="releaseDate">Release Date</label>
                <input type="date" class="form-control" id="releaseDate" name="releaseDate">
            </div>
            <div class="col-md-6 mb-3">
                <label for="coverImage">Link to cover image</label>
                <input type="url" class="form-control" id="coverImage" name="coverImage" placeholder="Link to cover image">
            </div>
        </div>
        <div class="text-right">
            <button type="submit" name="submit" class="btn btn-primary">Upload Song</button>
        </div>
    </form>
    
    <div class='container'>
        <h3 class="text-center">Songs added to album</h3>
        <table class="table"
        data-toggle="table"
        id="table"
        data-pagination="false"
        data-search="false"
        data-use-row-attr-func="true"
        data-reorderable-rows="true"
        data-url="includes/get_songs_from_cookie.inc.php">
            <thead>
                <tr>
                    <th data-field="name" data-sortable="false">Name</th>
                    <th data-field="price" data-sortable="false">Price</th>
                    <th data-field="length" data-sortable="false">Length</th>
                    <th data-field="genre_name" data-sortable="false">Genre</th>
                    <th data-field="score" data-sortable="false">Score</th>
                    <th data-field="release_date" data-sortable="false">Release Date</th>
                    <th data-field="cover_img" data-sortable="false">Cover</th>
                </tr>
            </thead>
        </table>
    </div>
<?php
    include_once "hf/artist_footer.php";
?>