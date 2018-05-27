	.ORIG x3000
;init counter
	LD R1,COUNTER
	AND R0,R0,#0
	ADD R0,R0,#1
	STR R0,R1,#0
;init A B C
	JSR FunInitABC
;odd or even
STARTECHO JSR FunIsOddCounter
	LD R1,SaveR1
	;0 even Player 2
	BRz PLAYER2
	;PLAYER1
	;echo Player 1
PLAYER2 ;echo Player 2
	;echo , choose a row and number of rocks:
	
;user input params


HALT
;address
SaveR1 .BLKW 1
DSR .FILL xFE04
DDR .FILL xFE06
KBSR .FILL xFE00
KBDR .FILL xFE02
;
ROWA .FILL x4000
ROWB .FILL x4001
ROWC .FILL x4002
COUNTER .FILL x4003
;
;value
INITA .FILL x0003
INITB .FILL x0005
INITC .FILL x0008
Newline .FILL x000A
EchoPlayer1 .STRINGZ "PLAYER1"
EchoPlayer2 .STRINGZ "PLAYER2"
EchoContent .STRINGZ ", choose a row and number of rocks:"
.END
;
;FUNC

;
;load init value to ABC
FunInitABC LD R1,ROWA
	LD R0,INITA 
	STR R0,R1,#0
	LD R0,INITB
	STR R0,R1,#1
	LD R0,INITC
	STR R0,R1,#3
	RET
	
;	
;is counter odd? ret R1 
FunIsOddCounter	LDI R1,COUNTER
SUBTRA	ADD R1,R1,#-2
	;even R1 = 0
	;odd R1 = 1
	BRp SUBTRA
	BRz SUBEVEN;sub to 0 even
	;sub to -1 odd
	AND R1,R1,#0
	ADD R1,R1,#1
	BRnzp ENDSUBTRA
SUBEVEN AND R1,R1,#0
ENDSUBTRA ST R1,SaveR1
RET

;
;echo
FunEcho Player 1
;