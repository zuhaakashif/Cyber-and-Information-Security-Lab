// Check if the Battery API is supported by the browser
if ('getBattery' in navigator) {
    // Get battery status
    navigator.getBattery().then(function(battery) {
       
        checkBatteryLevel(battery);
        
       
        battery.addEventListener('levelchange', function() {
            checkBatteryLevel(battery);
        });
    });
}

function checkBatteryLevel(battery) {
  
    var batteryLevel = battery.level * 100; 
    
   
    if (batteryLevel < 100) {
        
        switchToBatteryOptimizedMode();
    } else {
       
        switchToNormalMode();
    }
}

function switchToBatteryOptimizedMode() {
    
    document.documentElement.classList.add('dark-theme');
    

}

function switchToNormalMode() {
    
    // document.body.style.backgroundColor = '#ffffff';

}