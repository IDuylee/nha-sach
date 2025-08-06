let slideIndex = 1;
showSlides(slideIndex);

// Next/previous controls
function plusSlides(n) {
  showSlides(slideIndex += n);
}

// Thumbnail image controls
function currentSlide(n) {
  showSlides(slideIndex = n);
}

function showSlides(n) {
  let i;
  let slides = document.getElementsByClassName("myslides");
  let dots = document.getElementsByClassName("demo");
  let captionText = document.getElementById("caption");
  if (n > slides.length) {slideIndex = 1}
  if (n < 1) {slideIndex = slides.length}
  for (i = 0; i < slides.length; i++) {
    slides[i].style.display = "none";
  }
  for (i = 0; i < dots.length; i++) {
    dots[i].className = dots[i].className.replace(" active", "");
  }
  slides[slideIndex-1].style.display = "block";
  dots[slideIndex-1].className += " active";
  captionText.innerHTML = dots[slideIndex-1].alt;
}

function toggleCartDropdown() {
  const cartDropdown = document.querySelector('.cart-dropdown');
  cartDropdown.style.display = cartDropdown.style.display === 'block' ? 'none' : 'block';
}

const cashOption = document.getElementById('cash');
const creditCardOption = document.getElementById('credit-card');
const cardNumber = document.getElementById('card-number');
const expiryDate = document.getElementById('expiry-date');
const cvv = document.getElementById('cvv');

// Hàm cập nhật trạng thái các ô nhập
function updateCardInfoStatus() {
    const isCreditCard = creditCardOption.checked;
    cardNumber.disabled = !isCreditCard;
    expiryDate.disabled = !isCreditCard;
    cvv.disabled = !isCreditCard;
}

// Gán sự kiện 'change' cho các radio button
cashOption.addEventListener('change', updateCardInfoStatus);
creditCardOption.addEventListener('change', updateCardInfoStatus);

// Gọi hàm cập nhật ban đầu để đảm bảo trạng thái đúng ngay khi tải trang
updateCardInfoStatus();