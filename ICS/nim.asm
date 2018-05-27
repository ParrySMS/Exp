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
	JSR FunEchoP1;echo Player 1
PLAYER2 JSR FunEchoP2;echo Player 2
	JSR FunEchoCT ;echo , choose a row and number of rocks:
;user input params
INPUT LDI R3 KBSR;
	BRnzp INPUT
	LDI R0,KBDR
	BRnzp INPUT
	LDI R1,KBDR
;load R0-ROW R1-NUM 
	ST R0,SaveR0
	ST R1,SaveR1
;JSR
;JSR valid row
;valid num
	LD R0,SaveR0;valid row
	LD R5,CHARA;
	
	
	
	
	
	
	
HALT
;address
SaveR0 .BLKW 1
SaveR1 .BLKW 1
SaveR2 .BLKW 1
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
CHARA .FILL  x0041
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
;
FunEchoP1 LD R2,Newline
	;check ddr free
P1L1 LDI R3,DSR
BRzp P1L1
STI R2,DDR
;
	LEA R1, EchoPlayer1
;string
P1LOOP LDR R0,R1,#0
	BRz ENDP1
P1L2 LDI R3,DSR
	BRzp P1L2
	STI R0,DDR
	ADD R1,R1,#1 ;pointer
	BRnzp P1LOOP
ENDP1 RET
;
;
FunEchoP2 LD R2,Newline
	;check ddr free
P2L1 LDI R3,DSR
BRzp P1L1
STI R2,DDR
;
	LEA R1, EchoPlayer2
;string
P2LOOP LDR R0,R1,#0
	BRz ENDP2
P2L2 LDI R3,DSR
	BRzp P2L2
	STI R0,DDR
	ADD R1,R1,#1 ;pointer
	BRnzp P2LOOP
ENDP2 RET
;
;
FunEchoCT LD R2,Newline
	;check ddr free
CTL1 LDI R3,DSR
BRzp CTL1
STI R2,DDR
;
	LEA R1, EchoContent
;string
CTLOOP LDR R0,R1,#0
	BRz ENDCT
CTL2 LDI R3,DSR
	BRzp CTL2
	STI R0,DDR
	ADD R1,R1,#1 ;pointer
	BRnzp CTLOOP
ENDCT RET








