<script>
    document.addEventListener('DOMContentLoaded', function() {
        function updateCounts() {
            fetch('{{ route("selectedItems.count") }}')
                .then(response => response.json())
                .then(data => {
                    const forPackagingCount = document.getElementById('forPackagingCount');
                    if (forPackagingCount) {
                        forPackagingCount.textContent = data.count1;
                        forPackagingCount.style.display = data.count1 ? 'flex' : 'none';
                    }

                    const forDeliveryCount = document.getElementById('forDeliveryCount');
                    if (forDeliveryCount) {
                        forDeliveryCount.textContent = data.count2;
                        forDeliveryCount.style.display = data.count2 ? 'flex' : 'none';
                    }

                    const forPickupCount = document.getElementById('forPickupCount');
                    if (forPickupCount) {
                        forPickupCount.textContent = data.count3;
                        forPickupCount.style.display = data.count3 ? 'flex' : 'none';
                    }

                    const deniedOrders = document.getElementById('deniedOrders');
                    if (deniedOrders) {
                        deniedOrders.textContent = data.count4;
                        deniedOrders.style.display = data.count4 ? 'flex' : 'none';
                    }

                    const forGcashPayments = document.getElementById('forGcashPayments');
                    if (forGcashPayments) {
                        forGcashPayments.textContent = data.count5;
                        forGcashPayments.style.display = data.count5 ? 'flex' : 'none';
                    }

                    const forCODPayments = document.getElementById('forCODPayments');
                    if (forCODPayments) {
                        forCODPayments.textContent = data.count6;
                        forCODPayments.style.display = data.count6 ? 'flex' : 'none';
                    }

                    const forInStorePayments = document.getElementById('forInStorePayments');
                    if (forInStorePayments) {
                        forInStorePayments.textContent = data.count7;
                        forInStorePayments.style.display = data.count7 ? 'flex' : 'none';
                    }

                    const paymentAlert = document.getElementById('paymentAlert');
                    if (paymentAlert) {
                        if (data.count8 > 0) {
                            paymentAlert.classList.add('text-danger');
                            paymentAlert.classList.remove('d-none');
                        } else {
                            paymentAlert.classList.add('d-none');
                        }
                    }

                    const forPaymentProof = document.getElementById('forPaymentProof');
                    if (forPaymentProof) {
                        forPaymentProof.textContent = data.count9;
                        forPaymentProof.style.display = data.count9 ? 'flex' : 'none';
                    }
                })
                .catch(error => {
                    console.error('Error fetching count:', error);
                }).finally(() => {
                    setTimeout(updateCounts, 5000)
                });
        }
        updateCounts();
    });
</script>