from pad4pi import rpi_gpio

# Setup Keypad
KEYPAD = [
        ["1","2","3","A"],
        ["4","5","6","B"],
        ["7","8","9","C"],
        ["*","0","#","D"]
]

COL_PINS = [26,27,28,29] # BCM numbering
ROW_PINS = [22,23,24,25] # BCM numbering

factory = rpi_gpio.KeypadFactory()

keypad = factory.create_keypad(keypad=KEYPAD, row_pins=ROW_PINS, col_pins=COL_PINS)

def printKey(key):
        print(key)

# printKey will be called each time a keypad button is pressed
keypad.registerKeyPressHandler(printKey)
