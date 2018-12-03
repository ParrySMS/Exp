.text
; make BTB useless

; init var
	daddi $t0,$zero,10 ;10 is 010,mean 8
	daddi $a0,$zero,0  ;init a = 0
	daddi $s0,$zero,0 ;res of a < 0 
	
WHILE: 
	beqz $t0,EXIT ;while t>0
	slti $s0,$a0,0
	beqz $s0,SUB     ;a>=0
	daddi $a0,$a0,1  ;a<0 a++
	daddi $t0,$t0,-1  ;t--
	j WHILE

SUB:
	;a>=0 a--
	daddi $a0,$a0,-1 
	daddi $t0,$t0,-1 ;t--
	j WHILE
	
EXIT:
	halt
	

