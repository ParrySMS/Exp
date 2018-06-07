	.ORIG x3000
;init counter
	LD R1, COUNTER
	AND R0,R0,#0
	ADD R0,R0,#1
	STR R0,R1,#0
;init A B C
	JSR FunInitABC
	JSR FunShowRow
;odd or even
STARTECHO 
		
	JSR FunIsOddCounter
	;ret R5 
	ADD R5,R5,#0;
	;0 even Player 2
	BRz PLAYER2
	;PLAYER1
	JSR FunEchoP1;echo Player 1
	BRnzp INPUT
PLAYER2 JSR FunEchoP2 ;echo Player 2
INPUT	JSR FunEchoCT ;echo , choose a row and number of rocks:

;user input params
	JSR FunGetInput
		
;valid row

	;R4-->vaild flag
	AND R4,R4,#0
	JSR FunValidRow
	ADD R4,R4,#0
	BRn STARTECHO	
	
;valid num
	JSR FunValidNum
	ADD R4,R4,#0
	BRn STARTECHO	

;check win
	JSR FunHasWinner
	;ret r6 // 0 not // 1 win
	ADD R6,R6,#0
	BRp WIN
;next step	
	;COUNTER++
	LD R1,COUNTER
	LDR R0,R1,#0
	ADD R0,R0,#1
	STR R0,R1,#0
	JSR FunShowRow
	BRnzp STARTECHO	
;echo player + win 	
WIN
	JSR FunIsOddCounter
	;ret R5 
	ADD R5,R5,#0;
	BRz P2WIN
	;P1WIN
	JSR FunEchoP1
	BRnzp ENDWIN
P2WIN JSR FunEchoP2
ENDWIN JSR FunEchoWin; echo " Wins."



HALT

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
EchoPlayer1 .STRINGZ "Player 1"
EchoPlayer2 .STRINGZ "Player 2"
EchoContent .STRINGZ ", choose a row and number of rocks:"
EchoInvalid .STRINGZ "Invalid move. Try again."
EchoWin .STRINGZ " Wins."

;
;FUNC
;

;
; echo " Wins."
FunEchoWin
	LD R2,Newline
	;check ddr free
WL1 LDI R3,DSR
BRzp WL1
;not need new line
;	STI R2,DDR

	LEA R1, EchoWin
;string
WLOOP LDR R0,R1,#0
	BRz ENDW
WL2 LDI R3,DSR
	BRzp WL2
	STI R0,DDR
	ADD R1,R1,#1 ;pointer
	BRnzp WLOOP
ENDW RET


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
	STI R2,DDR; make a null row
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

;is counter odd? ret R5 
FunIsOddCounter	
LDI R5,COUNTER
SUBTRA	ADD R5,R5,#-2
	;even R5 = 0
	;odd R5 = -1
	BRp SUBTRA
	BRz SUBEVEN;sub to 0 even
	;sub to -1 odd
	AND R5,R5,#0
	ADD R5,R5,#1
	BRnzp ENDSUBTRA
SUBEVEN AND R5,R5,#0
ENDSUBTRA 
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
   ;advoid sytax error
   ADD R0,R0,#0
	;check ddr free
CTL1 LDI R3,DSR
	BRzp CTL1
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
	
	ST R7,SaveFGIR7
	INPUTR LDI R3 KBSR
	BRzp INPUTR	
	LDI R0,KBDR
	ST R0,SaveR0
	TRAP x21 
	INPUTN LDI R3 KBSR
	BRzp INPUTN
	LDI R0,KBDR ;same R0 for echo input
	TRAP x21
	ADD R1,R0,#0 ;save to R1
;save R0-ROW R1-NUM 
	ST R1,SaveR1
	LD R7,SaveFGIR7
RET
HALT
;reg
SaveR0 .BLKW 1
SaveR1 .BLKW 1
SaveR2 .BLKW 1
SaveFGIR7 .BLKW 1
;
;address
DSR .FILL xFE04
DDR .FILL xFE06
KBSR .FILL xFE00
KBDR .FILL xFE02
;
FunValidRow	
;ret R4
	ST R4,SaveFVRR4
    ST R7,SaveFVRR2;FOR JSR
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
    LD R7,SaveFVRR2
	LD R4,SaveFVRR4	
	RET
FVRIV 
	LD R4,SaveFVRR4	
    JSR FunEchoIV
	LD R7,SaveFVRR2
	RET
	
HALT
SaveFVRR2 .BLKW 1
SaveFVRR4 .BLKW 1
	
FunValidNum 
;ret R4
	;which row?
	;how many?
	;is over?
	ST R4,SaveFVNR4
	LD R0,SaveR0;rowchar
	LD R1,SaveR1 ;op_num_char
	; R1char 
	; char params check
	
	;intput max 9
	;char-9char-->nz
	LD R4,ASCII
	ADD R4,R4,#9
	NOT R4,R4
	ADD R4,R4,1
	ADD R1,R1,R4
	BRp FVNIV
	
	;intput min 0
	;char-0char-->
	LD R1,SaveR1 ;op_num_char
	LD R4,ASCII
	NOT R4,R4
	ADD R4,R4,1
	ADD R1,R1,R4
	BRn FVNIV
	
	;op_num_char - ASCII = op_num
	LD R1,SaveR1 ;op_num_char
	LD R4,ASCII
	NOT R4,R4
	ADD R4,R4,1
	ADD R1,R1,R4
	
	ST R7,SaveFVNR7;FOR JSR
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
	BRn FVNIV
	;if p ,can take
	STR R0,R3,#0;;save left
	;
	;ret value
	LD R2,SaveFVNR2
	LD R3,SaveFVNR3
	LD R7,SaveFVNR7
	LD R4,SaveFVNR4
	RET
FVNIV LD R4,SaveFVNR4	
	JSR FunEchoIV
	LD R7,SaveFVNR7
	RET
	
HALT
ASCII .FILL x0030
SaveFVNR2 .BLKW 1
SaveFVNR3 .BLKW 1
SaveFVNR7 .BLKW 1
SaveFVNR4 .BLKW 1

CHARA .FILL  x0041
CHARO .FILL  x006F
ROWA .FILL x4000
ROWB .FILL x4001
ROWC .FILL x4002

	
FunHasWinner
;ret r6 
;0 not win
;1 has winner
	ST R0,SaveFWR0
	ST R1,SaveFWR1
	ST R2,SaveFWR2
	ST R3,SaveFWR3
	
	LD R0,ROWA
	LDR R1,R0,#0 ;point a
	LDR R2,R0,#1 ;point b
	LDR R3,R0,#2 ;point c
	;init-->not has winner
	AND R6,R6,#0
	;IF WIN A+B+C=0
	ADD R0,R1,R2;
	ADD R0,R0,R3;
	BRp NOTWIN
	;has win
	ADD R6,R6,#1
NOTWIN 
	LD R0,SaveFWR0
	LD R1,SaveFWR1
	LD R2,SaveFWR2
	LD R3,SaveFWR3
	RET
SaveFWR0 .BLKW 1
SaveFWR1 .BLKW 1
SaveFWR2 .BLKW 1
SaveFWR3 .BLKW 1	
	

.END
	
	

