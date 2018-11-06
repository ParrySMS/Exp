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
mes_enter:    .asciiz "please enter two numbers:\n"		; the message
mes_res:    .asciiz "result:\n"		
CONTROL: .word32 0x10000
DATA: 	 .word32 0x10008

.text

;echo mes_enter

	lwu $t8,DATA($zero)		; $t8 = address of DATA register
	lwu $t9,CONTROL($zero)	; $t9 = address of CONTROL register
	
	daddi $v0,$zero,4       ; set for ascii
	
	ld $t1,int($zero)
	daddi $t1,$zero,mes_enter
	sd $t1,0($t8)           ; write *mes to DATA register
	sd $v0,0($t9)           ; echo      
	

;finish echo mes_enter


;get 2 numbers

	daddi $v0,$zero,8		
	sd $v0,0($t9)  			; get data1 a0
	lwu $a0,0($t8)	
	sd $v0,0($t9)  			; get data2  a1
	lwu $a1,0($t8)		
	
	daddi $a2,$zero,0        ;store a0*a1 = a2
	daddi $a3,$zero,32		 ;counter 32

	
;multi

FOR:
	andi $s0,$a1,1	     ;data2 AND get low bit
	beqz $s0,ELSE		
	daddu $a2,$a2,$a0    ;if !0 -->  product add data1
ELSE:
	dsll $a0,$a0,1		;data1 left move 1 bit
	dsrl $a1,$a1,1		;data2 right move 1 bit
	
	daddi $a3,$a3,-1	; counter-- (total 32)
	bnez $a3,FOR
	

;echo mes_res
	
	daddi $v0,$zero,4       ; set for ascii
	
	ld $t1,int($zero)
	daddi $t1,$zero,mes_res
	sd $t1,0($t8)           ; write *mes to DATA register
	sd $v0,0($t9)           ; echo      

;finish echo mes_res

;echo data

	daddi $v0,$zero,1		; set for unsigned integer output

	sw $a2,0($t8)		   ; write integer to DATA register
	sd $v0,0($t9)           ; write to CONTROL register and make it happen

;



	halt