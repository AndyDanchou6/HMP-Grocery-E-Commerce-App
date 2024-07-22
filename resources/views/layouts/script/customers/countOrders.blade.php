 <script>
     document.addEventListener('DOMContentLoaded', function() {
         function ordersCount() {

             fetch("{{ route('customers.countOrders') }}", {
                     method: 'GET',
                     headers: {
                         'X-CSRF-TOKEN': "{{ csrf_token() }}",
                         'Content-Type': 'application/json',
                         'Accept': 'application/json'
                     },
                     credentials: 'same-origin'
                 })
                 .then(response => {
                     return response.json();
                 }).then(data => {
                     const unpaidOrders = document.getElementById('unpaidOrders');
                     if (data.status === 200) {
                         if (unpaidOrders) {
                             unpaidOrders.textContent = data.count4;
                             unpaidOrders.style.display = data.count4 ? 'block' : 'none';
                         }
                     }
                 })
                 .catch(error => console.error("Fetching errors: ", error))
                 .finally(() => {
                     setTimeout(ordersCount, 5000);
                 });
         }
         ordersCount();
     });
 </script>

 <script>
     document.addEventListener('DOMContentLoaded', function() {
         function ordersCount() {
             fetch("{{ route('customers.countOrders') }}", {
                     method: 'GET',
                     headers: {
                         'X-CSRF-TOKEN': "{{ csrf_token() }}",
                         'Content-Type': 'application/json',
                         'Accept': 'application/json'
                     },
                     credentials: 'same-origin'
                 })
                 .then(response => {
                     return response.json();
                 }).then(data => {
                     const forPendingOrders = document.getElementById('forPendingOrders');
                     const forDeliveryOrders = document.getElementById('forDeliveryOrders');
                     const forPickupOrders = document.getElementById('forPickupOrders');
                     const forUnpaidOrders = document.getElementById('forUnpaidOrders');

                     if (data.status == 200) {
                         if (forPendingOrders) {
                             forPendingOrders.textContent = data.count1;
                             forPendingOrders.style.display = data.count1 ? 'block' : 'none';
                         }
                         if (forDeliveryOrders) {
                             forDeliveryOrders.textContent = data.count2;
                             forDeliveryOrders.style.display = data.count2 ? 'block' : 'none';
                         }

                         if (forPickupOrders) {
                             forPickupOrders.textContent = data.count3;
                             forPickupOrders.style.display = data.count3 ? 'block' : 'none';
                         }

                         if (forUnpaidOrders) {
                             forUnpaidOrders.textContent = data.count4;
                             forUnpaidOrders.style.display = data.count4 ? 'block' : 'none';
                         }
                     }
                 })
                 .catch(error => console.error("Fetching errors: ", error))
                 .finally(() => {
                     setTimeout(ordersCount, 5000);
                 });

         }
         ordersCount();
     })
 </script>