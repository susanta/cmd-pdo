<?php 
    include "partials/admin/header.php"; 
    include "partials/admin/navbar.php";    

    $article = new Article();

    $userId = $_SESSION['user_id'];

    $userArticles = $article->getArticlesByUser($userId);
    // var_dump($userArticles);
?>

<!-- Main Content -->
<main class="container my-5">
    <h2 class="mb-4">Welcome <?php echo $_SESSION['username'] ?> to your Admin Dashboard</h2>

    <div class="d-flex justify-content-between mb-4">
        <form class="d-flex align-items-center" action="<?php echo base_url('create-dummy-articles.php'); ?>" method="post">
            <label class="form-label me-2" for="articleCount">Number of Articles</label>
            <input id="articleCount" min="1" style="width: 100px" class="form-control me-2" name="article_count" type="number">
             <button id="articleCount" class="btn btn-primary" type="submit">Generate Articles</button>
        </form>

        <form action="<?php echo base_url("reorder-articles.php"); ?>" method="post">
            <button type="submit" name="reorder_articles" class="btn btn-warning">Reorder Article ID's</button>
        </form>

        <button id="deleteSelectedBtn" class="btn btn-danger">Delete Selected Articles</button>
    </div>

    <!-- Articles Table -->
    <div class="table-responsive">
        <table class="table table-bordered table-hover align-middle">
            <thead class="table-dark">
                <tr>
                    <th><input type="checkbox" name="" id="selectAll"></th>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Author</th>
                    <th>Published Date</th>
                    <th>Excerpt</th>
                    <th>Edit</th>
                    <th>Delete</th>
                </tr>
            </thead>
            <tbody>
                <?php if(!empty($userArticles)) : ?>
                    <?php foreach($userArticles as $userArticleItem) : ?>
                        <tr>
                            <td><input type="checkbox" value="<?php echo $userArticleItem->id ?>" class="articleCheckbox"></td>
                            <td><?php echo $userArticleItem->id ?></td>
                            <td><?php echo $userArticleItem->title ?></td>
                            <td><?php echo $_SESSION['username'] ?></td>
                            <td><?php echo $article->formatCreatedAt($userArticleItem->created_at); ?></td>
                            <td>
                                <?php echo $article->getExcerpt($userArticleItem->content); ?>
                            </td>
                            <td>
                                <a href="edit-article.php?id=<?php echo $userArticleItem->id; ?>" class="btn btn-sm btn-primary me-1">Edit</a>                                
                            </td>
                            <td>
                                <form onsubmit="confirmDelete(<?php echo $userArticleItem->id; ?>)" action="<?php echo base_url("delete-article.php") ?>" method="POST">
                                    <input type="hidden" name="id" value="<?php echo $userArticleItem->id; ?>">
                                    <!-- <button class="btn btn-sm btn-danger" onclick="confirmDelete(1)">Delete</button> -->
                                     <button class="btn btn-sm btn-danger">Delete</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>                
            </tbody>
        </table>
    </div>
</main>

<script>
    // select or deselct all checkboxes
    document.getElementById("selectAll").onclick = function() {
        let checkboxes = document.querySelectorAll(".articleCheckbox");

        for(let checkbox of checkboxes) {
            checkbox.checked = this.checked;
        }
    }

    document.getElementById("deleteSelectedBtn").onclick = function() {
        let selectedIds = [];
        let checkboxes = document.querySelectorAll(".articleCheckbox:checked");

        checkboxes.forEach(checkbox => {
            selectedIds.push(checkbox.value);
        });

        if(selectedIds.length === 0) {
            alert("Select al least one Id!");
            return;
        }

        if(confirm("Are you sure you want to delete this articles?")) {
            sendDeleteRequest(selectedIds);
        }

        function sendDeleteRequest(selectedIds) {
            console.log("DELETE REQUEST");
        }
    }
</script>

<?php include "partials/admin/footer.php" ?>