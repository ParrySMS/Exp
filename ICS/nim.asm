	.ORIG x3000
;init counter
	LD R1,COUNTER
	AND R0,R0,#0
	ADD R0,R0,#1
	STR R0,R1,#0
;init A B C
	JSR FunInitABC
;odd or even
STARTECHO 
	JSR FunShowRow
	JSR FunIsOddCounter
	;0 even Player 2
	BRz PLAYER2
	;PLAYER1
	JSR FunEchoP1;echo Player 1
PLAYER2 JSR FunEchoP2;echo Player 2
	JSR FunEchoCT ;echo , choose a row and number of rocks:
;user input params
	JSR FunGetInput
		
;JSR
;JSR valid row
;valid num
	;R4-->vaild flag
	AND R4,R4,#0
	JSR FunValidRow
	JSR FunValidNum
	ADD R4,R4,0
	BRn STARTECHO		
	;COUNTER++
	LD R1,COUNTER
	LDR R0,R1,#0
	ADD R0,R0,#1
	STR R0,R1,#0
	
	BRnzp STARTECHO	

		
HALT


;address
DSR .FILL xFE04
DDR .FILL xFE06
KBSR .FILL xFE00
KBDR .FILL xFE02
;

COUNTER .FILL x4003
;
;value
INITA .FILL x0003
INITB .FILL x0005
INITC .FILL x0008
Newline .FILL x000A

EchoRowA .STRINGZ "ROW A: "
EchoRowB .STRINGZ "ROW B: "
EchoRowC .STRINGZ "ROW C: "
EchoPlayer1 .STRINGZ "PLAYER1"
EchoPlayer2 .STRINGZ "PLAYER2"
EchoContent .STRINGZ ", choose a row and number of rocks:"
EchoInvalid .STRINGZ "Invalid move. Try again."

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
	STR R0,R1,#2
	RET
	
;	
;
FunShowRow
;trap x21 change R7 !!!
	ST R1,SaveFSRR1
	ST R2,SaveFSRR2
	ST R3,SaveFSRR3
	ST R7,SaveFSRR7

;Echo RA string
	LD R2,Newline
	;check ddr free
SRAL1 LDI R3,DSR
	BRzp SRAL1
	STI R2,DDR
	LEA R1, EchoRowA
;string
SRALOOP LDR R0,R1,#0
	BRz AO
SRAL2 LDI R3,DSR
	BRzp SRAL2
	STI R0,DDR
	ADD R1,R1,#1 ;pointer
	BRnzp SRALOOP
;loop echo A o
AO  LDI R2,ROWA
FORAO BRnz ENDASR
	LD R0,CHARO
	TRAP x21
	ADD R2,R2,-1
	BRnzp FORAO
ENDASR

;Echo RB string
	LD R2,Newline
	;check ddr free
SRBL1 LDI R3,DSR
	BRzp SRBL1
	STI R2,DDR
	LEA R1, EchoRowB
;string
SRBLOOP LDR R0,R1,#0
	BRz BO
SRBL2 LDI R3,DSR
	BRzp SRBL2
	STI R0,DDR
	ADD R1,R1,#1 ;pointer
	BRnzp SRBLOOP
;loop echo B o
BO	LDI R2,ROWB; R2 =row_num
FORBO BRnz ENDBSR
	LD R0,CHARO
	TRAP x21
	ADD R2,R2,-1
	BRnzp FORBO
ENDBSR
 
;Echo RC string
	LD R2,Newline
	;check ddr free
SRCL1 LDI R3,DSR
	BRzp SRCL1
	STI R2,DDR
	LEA R1, EchoRowC
;string
SRCLOOP LDR R0,R1,#0
	BRz CO
SRCL2 LDI R3,DSR
	BRzp SRCL2
	STI R0,DDR
	ADD R1,R1,#1 ;pointer
	BRnzp SRCLOOP
;loop echo C o
CO	LDI R2,ROWC; R2 =row_num
FORCO  
	BRnz ENDCSR
	LD R0,CHARO
	TRAP x21
	ADD R2,R2,-1
	BRnzp FORCO
	
ENDCSR
	LD R1,SaveFSRR1
	LD R2,SaveFSRR2
	LD R3,SaveFSRR3
	LD R7,SaveFSRR7
	RET

HALT
SaveFSRR1 .BLKW 1
SaveFSRR2 .BLKW 1
SaveFSRR3 .BLKW 1
SaveFSRR7 .BLKW 1
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
ENDSUBTRA ST R0,SaveR0
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
FunEchoCT 
	LD R2,Newline
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
;
;
FunEchoIV 

	LD R2,Newline
	;check ddr free
IVL1 LDI R3,DSR
	BRzp IVL1
	STI R2,DDR
;
	LEA R1, EchoInvalid
;string
IVLOOP LDR R0,R1,#0
	BRz ENDIV
IVL2 LDI R3,DSR
	BRzp IVL2
	STI R0,DDR
	ADD R1,R1,#1 ;pointer
	BRnzp IVLOOP
ENDIV 
ADD R4,R4,-1
RET
;

FunGetInput
	;advoid sytax error
	ADD R0,R0,#0
	INPUTR LDI R3 KBSR
	BRnzp INPUTR	
	LDI R0,KBDR
	
	INPUTN LDI R3 KBSR
	BRnzp INPUTN
	LDI R1,KBDR
	
;save R0-ROW R1-NUM 
	ST R0,SaveR0
	ST R1,SaveR1
RET
HALT
;reg
SaveR0 .BLKW 1
SaveR1 .BLKW 1
SaveR2 .BLKW 1

;
FunValidRow	
    LD R0,SaveR0;valid row
	LD R5,CHARA;
	LD R6,CHARA
	ADD R6,R6,#2;R6='C'
	;CHAR-A
	NOT R5,R5
	ADD R5,R5,#1
	ADD R1,R0,R5
	BRn FVRIV 
	;CHAR-C
	NOT R6,R6
	ADD R6,R6,#1
	ADD R1,R0,R6
	BRp FVRIV 
	RET
FVRIV JSR FunEchoIV
	RET
	
	
FunValidNum 
	;which row?
	;how many?
	;is over?

	LD R0,SaveR0;rowchar
	LD R1,SaveR1 ;op_num
	
	ST R2,SaveFVNR2
	LD R2,CHARA;
	NOT R2,R2
	ADD R2,R2,#1; row-A
	ADD R2,R0,R2; R2 = offset
	ST R3,SaveFVNR3 
	LD R3,ROWA
	ADD R3,R3,R2;add offset
	;R3=row address
	LDR R2,R3,#0 ;R2=row_num
	;check row_num and op_num
	;row_num - op_num
	NOT R1,R1
	ADD R1,R1,#1
	ADD R0,R2,R1; R0=left point
	BRnz FVNIV
	;if p ,can take
	STR R0,R3,#0;;save left
	;
	;ret value
	LD R2,SaveFVNR2
	LD R3,SaveFVNR3
	RET
	FVNIV JSR FunEchoIV
	RET
	
HALT
SaveFVNR2 .BLKW 1
SaveFVNR3 .BLKW 1
CHARA .FILL  x0041
CHARO .FILL  x006F
ROWA .FILL x4000
ROWB .FILL x4001
ROWC .FILL x4002
.END
	
