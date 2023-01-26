<nav class="navbar navbar-expand-lg navbar-dark bg-dark d-flex justify-content-between">
    <a class="navbar-brand ms-3" href="/">Chair Mania</a>
    <div>
        @auth
            <a href="/chairs/create"><button type="button" class="btn btn-light me-2">Add Product</button></a>
            <a href="/logout"><button type="button" class="btn btn-danger me-2">Logout</button></a>
        @endauth
    </div>
</nav>