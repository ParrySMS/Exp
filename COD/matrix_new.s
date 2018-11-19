.data
a:    .word      1,1,1,1,2,2,2,2,3,3,3,3,4,4,4,4
b:    .word      4,4,4,4,3,3,3,3,2,2,2,2,1,1,1,1
c:    .word      0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0
len:  .word      4

control: .word32 0x10000
data:    .word32 0x10008

.text
start:
	  ld r16,len(r0)	; mx line and col
      daddi r17,r0,0	; init i 0
loop1:
      slt r8,r17,r16	; set i
	  daddi r19,r0,0	; set j 0  
      beq r8,r0,exit1	; check i below 4
	  
loop2:
      dsll r8,r17,2		; 4i
	  daddi r21,r0,a     
      daddi r22,r0,b    ;  
      dadd r8,r8,r19	; 4i + j
      dsll r8,r8,3		; 8 ( 4i+j )
      daddi r23,r0,c    ;  
	  
      dadd r9,r8,r21	; address a
      dadd r10,r8,r22	; b
	  dadd r11,r8,r23	; c 
	  
	  ld r9,0(r9)		; load in a 
	  ld r10,0(r10)		; load in b
	  
	  daddi r19,r19,1	
	  dadd r12,r9,r10	;mxA + mxB
	  slt r8,r19,r16	
	  
      sd r12,0(r11)		; put into c[i][j] 
      
	  beq r8,r0,exit2	
      j loop2
exit2:
      daddi r17,r17,1	; i++
      j loop1
exit1: 
      halt