	.ORIG x3000
;init
	AND R0,R0,#0 ;var n
	AND R1,R1,#0 ;var a[i]
	AND R2,R2,#0 ;vae a[j]
	AND R3,R3,#0 ;var R3=R1-R2
	AND R4,R4,#0 ;address
	AND R5,R5,#0  ;R5=n-R6 or R5=n-R7
	AND R6,R6,#0
	AND R7,R7,#0  ;var j
;R1 is data
;R6 is index
;R4 is BASE address
;R5 is GRADE address	
COPY	LD R4,BASE
	ADD R4,R4,R6
	LD R5,GRADE
	ADD R5,R5,R6
	LDR R1,R4,#0
	STR R1,R5,#0
	ADD R6,R6,#1
;R6++ R6<=n?  R6-n <=0
	AND R0,R0,#0 ;var n
	ADD R0,R0,#15  
	NOT R0,R0
	ADD R0,R0,#1
	ADD R0,R6,R0
	BRnz COPY
;init data
	AND R6,R6,#0
	ADD R6,R6,#-1 
	
FORI    ADD R6,R6,#1
;init R0
	AND R0,R0,#0 ;var n
	ADD R0,R0,#15  
;R5=R6-n
	NOT R0,R0
	ADD R0,R0,#1
	ADD R5,R6,R0
	BRz ENDFORI
	ADD R7,R6,#0
FORJ	ADD R7,R7,#1
;R5=R7-n
;RO already -R0
	ADD R5,R7,R0
;j=15 still do	
	BRp ENDFORJ
;R1=a[i] R2=a[j] swap
;R4 is address
	LD R4,GRADE
	ADD R4,R4,R6
	LDR R1,R4,#0
	
	LD R4,GRADE
	ADD R4,R4,R7
	LDR R2,R4,#0
;R3=R1-R2 check R1?>R2
	NOT R2,R2
	ADD R2,R2,#1
	ADD R5,R2,R1
	BRzp FORJ
;return R2
	NOT R2,R2
	ADD R2,R2,#1
;if(R1<R2)
	LD R4,GRADE
	ADD R4,R4,R6 ;a[i]
	STR R2,R4,#0
	
	LD R4,GRADE
	ADD R4,R4,R7 ;a[j]
	STR R1,R4,#0
	BRnzp FORJ
ENDFORJ BRnzp FORI
ENDFORI AND R6,R6,#0
;END sort save res
;count A and B
;R0 level var
;R1 is numOfA
;R2 is numOfB
;R4 is address
;R5 is value
;R6 is index
;R7 = var-R0
	AND R1,R1,#0 ;var numOfA
	AND R2,R2,#0 ;vae numOfB
	AND R6,R6,#0 ;var index
	ADD R6,R6,#-1
	
COUNT	ADD R6,R6,#1
	;if !25%  !50%---R6-R0>0
	;must a or b
	AND R0,R0,#0
	ADD R0,R0,#8
	NOT R0,R0
	ADD R0,R0,#1
	ADD R7,R0,R6
	BRzp ENDCOUNT
	;check 25% a
	AND R0,R0,#0
	ADD R0,R0,#4
	NOT R0,R0
	ADD R0,R0,#1
	ADD R7,R0,R6
	BRzp COUNTB	
	;a check85
	LD R4,GRADE
	ADD R4,R4,R6
	LDR R5,R4,#0
	;if(R5>=85)
	LD R0,ALEVEL
	NOT R0,R0
	ADD R0,R0,#1
	ADD R7,R5,R0
	BRn COUNTB
	;else
	ADD R1,R1,#1
	BRnzp COUNT
	;if(R5>=75)
COUNTB	LD R0,BLEVEL
	NOT R0,R0
	ADD R0,R0,#1
	ADD R7,R5,R0
	BRn COUNT
	;else
	ADD R2,R2,#1
	BRnzp COUNT
	;R4 is address
ENDCOUNT LD R4,NUM
	STR R1,R4,#0
	STR R2,R4,#1
HALT
BASE .FILL x3200
GRADE .FILL x4000
NUM .FILL x4100
;85
ALEVEL .FILL x0055
;75
BLEVEL .FILL x004B
.END