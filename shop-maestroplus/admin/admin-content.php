<?php
if (!defined('BASE_URL')) {
    require_once '../includes/config.php';
}
?>
<!-- Login Container -->
<div id="login-container" class="login-container" style="display: <?= isset($_SESSION['user_id']) ? 'none' : 'block' ?>">
    <div class="login-box">
        <h2>Admin Login</h2>
        <form id="admin-login-form">
            <div class="form-group">
                <label for="username">Email</label>
                <input type="email" id="username" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-success w-100">Login</button>
        </form>
    </div>
</div>

<!-- Dashboard Container -->
<div id="dashboard-container" style="display: <?= isset($_SESSION['user_id']) ? 'block' : 'none' ?>">
    <button class="mobile-menu-toggle" id="mobile-menu-toggle">
        <i class="fas fa-bars"></i>
    </button>
    
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="logo">Admin Panel</div>
        <nav>
            <ul>
                <li><a href="#dashboard" class="active"><i class="fas fa-home"></i> Dashboard</a></li>
                <li><a href="#products"><i class="fas fa-box"></i> Products</a></li>
                <li><a href="#orders"><i class="fas fa-shopping-cart"></i> Orders</a></li>
                <li><a href="#users"><i class="fas fa-users"></i> Users</a></li>
                <li><a href="<?= BASE_URL ?>"><i class="fas fa-sign-out-alt"></i> Back to Store</a></li>
            </ul>
        </nav>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Dashboard Section -->
        <section id="dashboard" class="section active">
            <h2>Dashboard</h2>
            <div class="metrics-container">
                <div class="metric-card">
                    <i class="fas fa-box"></i>
                    <h3>Total Products</h3>
                    <p id="total-products">0</p>
                </div>
                <div class="metric-card">
                    <i class="fas fa-shopping-cart"></i>
                    <h3>Active Orders</h3>
                    <p id="active-orders">0</p>
                </div>
                <div class="metric-card">
                    <i class="fas fa-users"></i>
                    <h3>Registered Users</h3>
                    <p id="registered-users">0</p>
                </div>
            </div>
            <div class="notifications">
                <h3>Recent Notifications</h3>
                <div id="notifications-list"></div>
            </div>
        </section>

        <!-- Products Section -->
        <section id="products" class="section">
            <h2>Product Management</h2>
            <div class="product-controls mb-4">
                <div class="row">
                    <div class="col-md-4">
                        <input type="text" class="form-control" id="product-search" placeholder="Search products...">
                    </div>
                    <div class="col-md-3">
                        <select class="form-control" id="category-filter">
                            <option value="">All Categories</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <select class="form-control" id="stock-filter">
                            <option value="">All Stock Status</option>
                            <option value="in">In Stock</option>
                            <option value="low">Low Stock</option>
                            <option value="out">Out of Stock</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <button class="btn btn-primary w-100" onclick="openAddProductModal()">Add Product</button>
                    </div>
                </div>
            </div>
            <div class="products-list" id="products-container"></div>
            <div class="pagination-controls mt-3 text-center" id="product-pagination"></div>
        </section>

        <!-- Orders Section -->
        <section id="orders" class="section">
            <h2>Order Management</h2>
            <div class="order-controls mb-4">
                <div class="row">
                    <div class="col-md-4">
                        <input type="text" class="form-control" id="order-search" placeholder="Search orders...">
                    </div>
                    <div class="col-md-3">
                        <select class="form-control" id="status-filter">
                            <option value="">All Status</option>
                            <option value="pending">Pending</option>
                            <option value="processing">Processing</option>
                            <option value="shipped">Shipped</option>
                            <option value="delivered">Delivered</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <input type="date" class="form-control" id="date-filter">
                    </div>
                    <div class="col-md-2">
                        <button class="btn btn-primary w-100" onclick="exportOrders()">Export</button>
                    </div>
                </div>
            </div>
            <div class="orders-list" id="orders-container"></div>
            <div class="pagination-controls mt-3 text-center" id="order-pagination"></div>
        </section>

        <!-- Users Section -->
        <section id="users" class="section">
            <h2>User Management</h2>
            <div class="users-list" id="users-container"></div>
        </section>
    </div>
</div>

<!-- Product Modal -->
<div class="modal fade" id="productModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add/Edit Product</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="product-form">
                    <input type="hidden" id="product-id">
                    <div class="mb-3">
                        <label class="form-label">Product Name</label>
                        <input type="text" class="form-control" id="product-name" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea class="form-control" id="product-description" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Price</label>
                        <input type="number" class="form-control" id="product-price" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Stock</label>
                        <input type="number" class="form-control" id="product-stock" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Category</label>
                        <input type="text" class="form-control" id="product-category">
                    </div>
                    <div class="mb-3 image-upload-container">
                        <label class="form-label">Product Image</label>
                        <div class="custom-file-input">
                            <input type="file" class="form-control" id="product-image" accept="image/*">
                            <label class="custom-file-label" for="product-image">Choose file...</label>
                        </div>
                        <div id="image-preview" class="image-preview empty">
                            <span>No image selected</span>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="saveProduct()">Save</button>
            </div>
        </div>
    </div>
</div>

<!-- Order Status Modal -->
<div class="modal fade" id="orderModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Update Order Status</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="order-form">
                    <input type="hidden" id="order-id">
                    <div class="mb-3">
                        <label class="form-label">Order Status</label>
                        <select class="form-control" id="order-status">
                            <option value="pending">Pending</option>
                            <option value="shipped">Shipped</option>
                            <option value="delivered">Delivered</option>
                            <option value="cancelled">Cancelled</option>
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="updateOrder()">Update</button>
            </div>
        </div>
    </div>
</div> 