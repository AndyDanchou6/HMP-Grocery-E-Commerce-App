// document.addEventListener("DOMContentLoaded", function () {
//     var subTotalField = document.querySelectorAll(".item-sub-total");
//     var totalContainer = {};

//     subTotalField.forEach(function (subtotal) {
//         var itemReferenceNo = subtotal.getAttribute("data-item-id");
//         var [referenceNo, itemId] = itemReferenceNo.split("_");

//         var price = parseFloat(
//             document
//                 .querySelector(
//                     '.item-price[data-item-id="' + itemReferenceNo + '"]'
//                 )
//                 .value.replace(/[^0-9.-]+/g, "")
//         );
//         var quantity = parseInt(
//             document.querySelector(
//                 '.item-quantity[data-item-id="' + itemReferenceNo + '"]'
//             ).value
//         );

//         if (quantity < 0) {
//             alert("Quantity cannot be negative.");
//             quantity = 0;
//             document.querySelector(
//                 '.item-quantity[data-item-id="' + itemReferenceNo + '"]'
//             ).value = 0;
//         }

//         var userSubTotalField = document.querySelector(
//             '.item-sub-total[data-item-id="' + itemReferenceNo + '"]'
//         );

//         var tempSubTotal = price * quantity;
//         userSubTotalField.value = tempSubTotal.toLocaleString("en-PH", {
//             style: "currency",
//             currency: "PHP",
//         });

//         if (!totalContainer[referenceNo]) {
//             totalContainer[referenceNo] = tempSubTotal;
//         } else {
//             totalContainer[referenceNo] += tempSubTotal;
//         }
//     });

//     var totals = document.querySelectorAll(".purchase-total");

//     totals.forEach(function (total) {
//         var totalId = total.getAttribute("data-total-id");
//         total.value = totalContainer[totalId].toLocaleString("en-PH", {
//             style: "currency",
//             currency: "PHP",
//         });
//     });
// });
