<!doctype html>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        body { font-family: Arial, sans-serif; text-align: center; background: #f4f4f4; }
        .locker-overlay {
            display: none;
            position: fixed;
            top: 0; left: 0; width: 100%; height: 100%;
            background: rgba(0, 0, 0, 0.7);
            z-index: 9999;
        }
        .locker-box {
            width: 400px; padding: 20px;
            background: #fff;
            border-radius: 15px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.3);
            text-align: center;
            position: absolute;
            top: 50%; left: 50%;
            transform: translate(-50%, -50%);
            animation: fadeIn 0.3s ease-in-out;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translate(-50%, -55%); }
            to { opacity: 1; transform: translate(-50%, -50%); }
        }
        .locker-box img { width: 100%; border-radius: 12px; margin-bottom: 10px; }
        .offer { padding: 12px; margin: 8px 0; background: #ff9800; color: white; border-radius: 8px; cursor: pointer; font-weight: bold; }
        .offer:hover { background: #e68900; transform: scale(1.05); transition: 0.2s; }
        .timer { font-size: 18px; margin-top: 10px; display: flex; justify-content: center; align-items: center; }
        .timer img { width: 50px; height: 50px; margin-right: 5px; }
        .close-btn {
            margin-top: 12px;
            padding: 8px 20px;
            background: #d32f2f;
            color: white;
            border: none;
            cursor: pointer;
            border-radius: 8px;
            font-weight: bold;
            transition: 0.3s;
        }
        .close-btn:hover { background: #b71c1c; transform: scale(1.1); }
    .cpa-btn {
    background: linear-gradient(45deg, #ff9800, #ff5722);
    color: white;
    font-size: 18px;
    font-weight: bold;
    padding: 12px 20px;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    transition: all 0.3s ease-in-out;
    position: relative;
    overflow: hidden;
}

.cpa-btn:hover {
    background: linear-gradient(45deg, #ff5722, #e64a19);
    transform: scale(1.05);
}

.cpa-btn:active {
    transform: scale(0.95);
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
}
</style>


    <div class="locker-overlay" id="locker">
        <div class="locker-box">
            <img src="https://m.media-amazon.com/images/I/51sqOF2L+iL.jpg" alt="هدية" /> 
            <h2>👑Comlete 1 offer below to get your followers👑</h2>
            <div id="offerContainer">Loading...</div>
            <div class="timer">
                <img src="https://upload.wikimedia.org/wikipedia/commons/f/f4/Analog_clock_animation.gif" alt="ساعة" />
                <span id="countdown">03:00</span>
            </div>
            <button class="close-btn" onclick="closeLocker()">Close</button>
        </div>
    </div>

    <script>
        let giftUrl = "";
        let offerCompleted = false;

        function openLocker(url) {
            giftUrl = url;
            document.getElementById('locker').style.display = 'block';
            loadOffers();
            startCountdown(180);
            checkOfferCompletion();
        }

        function closeLocker() {
            document.getElementById('locker').style.display = 'none';
        }

                function loadOffers() {
            fetch("https://d30xmmta1avvoi.cloudfront.net/public/offers/feed.php?user_id=354591&api_key=6b29d7158039c22af8fcd52569ff9a77&s1=&s2=")
                .then(response => response.json())
                .then(offers => {
                    let html = '';
                    offers.slice(0, 5).forEach(offer => {
                        html += `<div class="offer" onclick="trackOffer('${offer.id}', '${offer.url}')">🔗 ${offer.anchor}</div>`;
                    });
                    document.getElementById("offerContainer").innerHTML = html;
                })
                .catch(() => {
                    document.getElementById("offerContainer").innerHTML = '<p style="color:red;">⚠ حدث خطأ أثناء جلب العروض.</p>';
                });
        }

       function trackOffer(offerId, offerUrl) {
            if (offerUrl) {
                window.open(offerUrl, "_blank");
                checkingInterval = setInterval(() => checkOfferCompletion(offerId), 5000);
            } else {
                alert("⚠ حدث خطأ، لم يتم العثور على رابط العرض.");
            }
        }

        function checkOfferCompletion(offerId) {
            fetch(`https://d30xmmta1avvoi.cloudfront.net/public/offers/check_status.php?user_id=354591&offer_id=${offerId}`)
                .then(response => response.json())
                .then(data => {
                    if (data.status === "completed") {
                        clearInterval(checkingInterval);
                        document.getElementById("rewardButton").style.display = "block";
                    }
                })
                .catch(() => console.log("خطأ أثناء التحقق من حالة العرض."));
        }

        function startCountdown(duration) {
            let timer = duration, minutes, seconds;
            let interval = setInterval(function () {
                minutes = Math.floor(timer / 60);
                seconds = timer % 60;
                minutes = minutes < 10 ? "0" + minutes : minutes;
                seconds = seconds < 10 ? "0" + seconds : seconds;
                document.getElementById('countdown').textContent = minutes + ":" + seconds;
                if (--timer < 0 || offerCompleted) {
                    clearInterval(interval);
                    if (!offerCompleted) {
                        alert("⏳ Time is over no offer completed");
                        closeLocker();
                    }
                }
            }, 1000);
        }
    </script>

</!doctype>