;
; Memory Mapped I/O area
;
; Address of CONTROL and DATA registers
;
; Set CONTROL = 1, Set DATA to Unsigned Integer to be output
; Set CONTROL = 2, Set DATA to Signed Integer to be output
; Set CONTROL = 3, Set DATA to Floating Point to be output
; Set CONTROL = 4, Set DATA to address of string to be output
; Set CONTROL = 5, Set DATA+5 to x coordinate, DATA+4 to y coordinate, and DATA to RGB colour to be output
; Set CONTROL = 6, Clears the terminal screen
; Set CONTROL = 7, Clears the graphics screen
; Set CONTROL = 8, read the DATA (either an integer or a floating-point) from the keyboard
; Set CONTROL = 9, read one byte from DATA, no character echo.
;

.data
int:	.word 0xF9876543987625aa	; a 64-bit integer
mes:    .asciiz "Hello World\n"		; the message

CONTROL: .word32 0x10000
DATA: 	 .word32 0x10008

.text
	lwu $t8,DATA($zero)		; $t8 = address of DATA register
	lwu $t9,CONTROL($zero)	; $t9 = address of CONTROL register
	
	daddi $v0,$zero,4       ; set for ascii
	
	ld $t1,int($zero)
	daddi $t1,$zero,mes
	sd $t1,0($t8)           ; write *mes to DATA register
	sd $v0,0($t9)           ; echo      
	
	
	daddi $v0,$zero,2		; set for signed integer output

	dsub $t1,$t1,$t1
	daddi $t1,$t1,100
	
	sd $t1,0($t8)           ; write integer to DATA register
	sd $v0,0($t9)           ; write to CONTROL register and make it happen
	
	halt