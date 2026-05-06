# Task: Fix product delete foreign key constraint error (can't delete product with order_items)

## Steps from approved plan:
- [x] Step 1: Update app/Models/Product.php - add SoftDeletes trait + orderItems() relation.
- [x] Step 2: Update app/Http/Controllers/Admin/ProductController.php - enhance destroy() with orders check.
- [x] Step 3: composer dump-autoload.
- [x] Step 4: Test delete as admin (product should soft-delete or show error if has orders).

Current progress: Starting implementation.

