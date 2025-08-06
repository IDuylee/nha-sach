function confirmPayment() {
    console.log("Hàm xác nhận thanh toán được gọi...");
    let name = document.getElementById("name").value;
    let phone = document.getElementById("phone").value;
    let address = document.getElementById("address").value;

    if (name === "" || phone === "" || address === "") {
        alert("Vui lòng điền đầy đủ thông tin giao hàng.");
        return;
    }

    let paymentMethod = document.querySelector('input[name="payment"]:checked').value;
    if (paymentMethod === "credit-card") {
        let cardNumber = document.getElementById("card-number").value;
        let expiryDate = document.getElementById("expiry-date").value;
        let cvv = document.getElementById("cvv").value;

        if (cardNumber === "" || expiryDate === "" || cvv === "") {
            alert("Vui lòng điền thông tin thẻ đầy đủ.");
            return;
        }
    }

    alert("Đơn hàng của bạn đã được xác nhận!");
    window.location.href = "Trang_chu.html";
}

document.getElementById("credit-card").addEventListener("change", function () {
    document.getElementById("card-number").disabled = false;
    document.getElementById("expiry-date").disabled = false;
    document.getElementById("cvv").disabled = false;
});

document.getElementById("cash").addEventListener("change", function () {
    document.getElementById("card-number").disabled = true;
    document.getElementById("expiry-date").disabled = true;
    document.getElementById("cvv").disabled = true;
});
