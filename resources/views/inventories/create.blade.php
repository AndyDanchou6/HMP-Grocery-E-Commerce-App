 <div class="modal fade" id="createModal" tabindex="-1" aria-hidden="true">
   <div class="modal-dialog" role="document">
     <div class="modal-content">
       <div class="modal-header">
         <h5 class="modal-title" id="exampleModalLabel1">Create New Product</h5>
         <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
       </div>
       <div class="modal-body">
         <form action="" method="POST" id="createFormElement">
           <div class="row">
             <div class="col mb-3">
               <label for="category_id" class="form-label">Category</label>
               <select class="form-select" name="category_id" id="category_id">

                 <!-- Options will be dynamically added here -->
               </select>
             </div>
           </div>
           <div class="row">
             <div class="col mb-3">
               <label for="product_img" class="form-label">Avatar</label>
               <input type="file" id="product_img" name="product_img" class="form-control" />
             </div>
           </div>
           <div class="row">
             <div class="col mb-3">
               <label for="productBasic" class="form-label">Product Name</label>
               <input type="text" id="product_name" name="product_name" class="form-control" placeholder="Enter Product" />
             </div>
           </div>
           <div class="row g-2">
             <div class="col mb-0">
               <label for="priceBasic" class="form-label">Price</label>
               <input type="number" id="price" name="price" class="form-control" placeholder="Enter Price" />
             </div>
             <div class="col mb-0">
               <label for="quantityBasic" class="form-label">Quantity</label>
               <input type="number" id="quantity" name="quantity" class="form-control" placeholder="Enter Quantity" />
             </div>
           </div>
       </div>
       <div class="modal-footer">
         <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
           Close
         </button>
         <button type="submit" class="btn btn-primary">Create</button>
       </div>
       </form>
     </div>
   </div>
 </div>
 </div>
 </div>
 <script src="{{ asset('assets/js/crud/inventories/create.js') }}"> </script>