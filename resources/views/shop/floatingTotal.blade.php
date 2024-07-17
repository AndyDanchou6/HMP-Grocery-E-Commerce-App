<div id="floating-total" class="card bg-light shadow-sm position-fixed" style="width: 200px; bottom: 50px; right: 35px; z-index: 1000;">
    <div class="card-body ">
        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text">₱</span>
            </div>
            <input type="number" class="form-control text-right" value="0" readonly>
        </div>
        <a id="toCartButton"><button class="btn btn-success btn-block">Cart</button></a>
    </div>
</div>

<button id="floatingToggle" class="position-fixed bg-light shadow-lg rounded-circle" style="width: 50px; height: 50px; bottom: 91px; right: 5px; z-index: 1000; border: solid 1px grey;" onmouseover="this.style.transform='scale(1.1)'" onmouseout="this.style.transform='scale(1)'">
    <p style="font-size: 32px; margin: 0; margin-bottom: 8px; color: grey;">></p>
</button>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const floatingToggle = document.querySelector('#floatingToggle');
        const totalField = document.querySelector('#floating-total');
        var toggleIcon = floatingToggle.querySelector('p');

        toggleDisplayed = true;

        floatingToggle.addEventListener('click', function() {
            
            totalField.style.transition = '1s ease';

            if (toggleDisplayed == false) {
                totalField.style.transform = 'translateX(0)';

                toggleDisplayed = true;
                toggleIcon.innerHTML = '>';
            } else {
                totalField.style.transform = 'translateX(250px)';

                toggleDisplayed = false;
                toggleIcon.innerHTML = '<';
            }
        })
    })
</script>