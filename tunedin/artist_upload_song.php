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
    <!-- Song Upload Form -->
    <form class="custom-form" action="includes/uploadsong.inc.php" method="post">
        <h1 class="display-4">Upload a song</h1>

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
                <input type="number" class="form-control" id="score" name="score" placeholder="Score" min=0 max=10.9 step="0.1">
            </div>
        </div>

        <!-- Row for release date and cover image link inputs -->
        <div class="form-row">
            <div class="col-md-6 mb-3">
                <label for="releaseDate">Release Date</label>
                <input required type="date" class="form-control" id="releaseDate" name="releaseDate">
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

<?php
    include_once "hf/artist_footer.php";
?>