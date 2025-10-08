<?php
include('config.php');
$dsn = "mysql:host=$dbHost;dbname=$dbName;charset=UTF8";
$pdo = new PDO($dsn, $dbUser, $dbPass);
$adultAnimals = $pdo->query("SELECT * FROM animal ORDER BY RAND()")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ontdek ze allemaal</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div id="message" style="position: fixed; top: 20px; left: 50%; transform: translateX(-50%); padding: 10px 20px; background: rgba(0,0,0,0.8); color: white; border-radius: 5px; display: none; z-index: 1000;"></div>
    
    <div class="cards">
        <?php $cardClasses = ['card1', 'card2', 'card3', 'card4', 'card5']; ?>
        <?php for($i = 0; $i < 5; $i++): ?>
            <div class="<?= $cardClasses[$i] ?>" data-animal="<?= $adultAnimals[$i]['Name'] ?>" onclick="flipCard(this, '<?= $adultAnimals[$i]['Name'] ?>')">
                <img src="backside.png" style="width: 200px;">
            </div>
        <?php endfor; ?>
    </div>
    
    <div class="babys" style="display: grid; grid-template-columns: repeat(3, 220px); gap: 20px;">
        <?php foreach($adultAnimals as $animal): ?>
            <div data-animal="<?= $animal['Name'] ?>" onclick="selectBaby('<?= $animal['Name'] ?>')" style="border: 3px dashed #ccc; border-radius: 10px; cursor: pointer; padding: 5px;">
                <img src="animalcards/<?= $animal['Name'] ?>_baby.png" style="width: 200px;">
            </div>
        <?php endforeach; ?>
    </div>

    <script>
        let currentCard = null;
        let currentAnimal = null;
        let cardsPlaced = 0;
        
        function flipCard(cardElement, animalName) {
            if (currentCard) return;
            cardElement.innerHTML = `<img src="animalcards/${animalName}_adult.png" style="width: 200px;">`;
            currentCard = cardElement;
            currentAnimal = animalName;
            showMessage(`Klik op de ${animalName} baby`);
        }
        
        function selectBaby(animalName) {
            if (!currentCard) {
                showMessage('draai een kaart');
                return;
            }
            
            if (currentAnimal === animalName) {
                document.querySelector(`[data-animal="${animalName}"]`).style.border = '3px solid #4CAF50';
                currentCard.style.display = 'none';
                currentCard = null;
                currentAnimal = null;
                cardsPlaced++;
                showMessage('goed');
                
                if (cardsPlaced === <?= count($adultAnimals) ?>) {
                    showMessage('goed gedaan alles is klaar');
                }
            } else {
                showMessage('fout');
                currentCard.innerHTML = '<img src="backside.png" style="width: 200px;">';
                currentCard = null;
                currentAnimal = null;
            }
        }
        
        function showMessage(text) {
            const msg = document.getElementById('message');
            msg.textContent = text;
            msg.style.display = 'block';
            setTimeout(() => msg.style.display = 'none', 2000);
        }
    </script>
</body>
</html>