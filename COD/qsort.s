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
echo_n:  .asciiz  "\n"
before:   .asciiz "before sort the array is:\n"		; the message
after:     .asciiz "after sort the array is:\n"		; the message

CONTROL: .word32 0x10000
DATA: 	 .word32 0x10008
AR1: 	 .word32 0x10040
AR2:	 .word32 0x10072
AR3:     .word32 0x10104
AR4:	 .word32 0x10136
.text

init:

	lwu $t8,DATA($zero)		; $t8 = address of DATA register
	lwu $t9,CONTROL($zero)	; $t9 = address of CONTROL register

before_echo: 
;{
	
	daddi $v0,$zero,4       ; set for ascii

	ld $t1,int($zero)
	daddi $t1,$zero,before
	sd $t1,0($t8)           ; write *mes to DATA register
	sd $v0,0($t9)           ; echo  before

;}
	
;put num in ar
;{	
	daddi $v0,$zero,2
	daddi $v1,$zero,4       ; set for ascii
	
	lwu $a0,AR1($zero) ; $a0 = *ar
	
	dsub $t0,$t0,$t0  ; t0 = 0
	daddi $t0,$t0,8 
	sd $t0,0($a0) 
	sd $t0,0($t8) 
	sd $v0,0($t9) 
	
	ld $t2,int($zero)
	daddi $t2,$zero,echo_n
	sd $t2,0($t8)           ; write *mes to DATA register
	sd $v1,0($t9)           ; echo  "\n"
	
	dsub $t0,$t0,$t0  ; t0 = 0
	daddi $t0,$t0,6
	sd $t0,4($a0) 
	sd $t0,0($t8) 
	sd $v0,0($t9) 
	

	ld $t2,int($zero)
	daddi $t2,$zero,echo_n
	sd $t2,0($t8)           ; write *mes to DATA register
	sd $v1,0($t9)           ; echo  "\n"
	
	dsub $t0,$t0,$t0  ; t0 = 0
	daddi $t0,$t0,3 
	sd $t0,8($a0) 
	sd $t0,0($t8) 
	sd $v0,0($t9) 

	ld $t2,int($zero)
	daddi $t2,$zero,echo_n
	sd $t2,0($t8)           ; write *mes to DATA register
	sd $v1,0($t9)           ; echo  "\n"
	
	lwu $a0,AR2($zero) ; $a0 = *ar
	
	dsub $t0,$t0,$t0  ; t0 = 0
	daddi $t0,$t0,7 
	sd $t0,0($a0) 
	sd $t0,0($t8) 
	sd $v0,0($t9) 

	ld $t2,int($zero)
	daddi $t2,$zero,echo_n
	sd $t2,0($t8)           ; write *mes to DATA register
	sd $v1,0($t9)           ; echo  "\n"
	
	dsub $t0,$t0,$t0  ; t0 = 0
	daddi $t0,$t0,1 
	sd $t0,4($a0) 
	sd $t0,0($t8) 
	sd $v0,0($t9) 

	ld $t2,int($zero)
	daddi $t2,$zero,echo_n
	sd $t2,0($t8)           ; write *mes to DATA register
	sd $v1,0($t9)           ; echo  "\n"
	
	dsub $t0,$t0,$t0  ; t0 = 0
	daddi $t0,$t0,0
	sd $t0,8($a0) 
	sd $t0,0($t8) 
	sd $v0,0($t9) 
	
	ld $t2,int($zero)
	daddi $t2,$zero,echo_n
	sd $t2,0($t8)           ; write *mes to DATA register
	sd $v1,0($t9)           ; echo  "\n"
	
	lwu $a0,AR3($zero) ; $a0 = *ar
	
	dsub $t0,$t0,$t0  ; t0 = 0
	daddi $t0,$t0,9 
	sd $t0,0($a0) 
	sd $t0,0($t8) 
	sd $v0,0($t9) 
	
	ld $t2,int($zero)
	daddi $t2,$zero,echo_n
	sd $t2,0($t8)           ; write *mes to DATA register
	sd $v1,0($t9)           ; echo  "\n"
	
	dsub $t0,$t0,$t0  ; t0 = 0
	daddi $t0,$t0,4 
	sd $t0,4($a0) 
	sd $t0,0($t8) 
	sd $v0,0($t9) 
	
	ld $t2,int($zero)
	daddi $t2,$zero,echo_n
	sd $t2,0($t8)           ; write *mes to DATA register
	sd $v1,0($t9)           ; echo  "\n"
	
	
	dsub $t0,$t0,$t0  ; t0 = 0
	daddi $t0,$t0,5
	sd $t0,8($a0) 
	sd $t0,0($t8) 
	sd $v0,0($t9) 
	
	ld $t2,int($zero)
	daddi $t2,$zero,echo_n
	sd $t2,0($t8)           ; write *mes to DATA register
	sd $v1,0($t9)           ; echo  "\n"
	
	lwu $a0,AR4($zero) ; $a0 = *ar
	
	dsub $t0,$t0,$t0  ; t0 = 0
	daddi $t0,$t0,2
	sd $t0,0($a0) 
	sd $t0,0($t8) 
	sd $v0,0($t9) 
	
	ld $t2,int($zero)
	daddi $t2,$zero,echo_n
	sd $t2,0($t8)           ; write *mes to DATA register
	sd $v1,0($t9)           ; echo  "\n"
	
;}

	
	
qsort:  ;{

;save params to stack {
	daddi $sp,$sp,-12	; save 3 params
	sd $s2,8($sp)		; s2 = right
	sd $s1,4($sp) 		; s1 = left
	sd $s0,0($sp) 	 	; so = *ar
	
	daddi $s0,$a0,0		; copy params
	daddi $s1,$a1,0
	daddi $s2,$a2,0 
;}

	slt $t0,$s2,$s1 	; t0 = (righr < left)?
	beqz $t0,end_qsort
	
						;lefy <= right
	
	daddi $t1,$s1,0 	; first_index = left
	daddi $t2,$s2,0	 	; last_index = right;
	
	dsll $t3,$s1,2 		; adr of left ,
	dadd $t3,$s0,$t3	; *ar + (4*left)
	ld $t3,0($t3)		; t3 = key = ar[left]

sort_while1: 
;{
	dsub $t0,$s2,$s1    ;while (left != right) 
	beqz $t0,end_sort_while1
;}
sort_while2:
;{
	dsll $t5,$s2,2 		; adr of right ,
	dadd $t5,$s0,$t5	; *ar + (4*right)
	ld $t5,0($t5)		; t5 = ar[right]
	
	slt $t0,$t3,$t5 	; t0 = (key < ar[right])?
	slt $t9,$s1,$s2 	; t9 = (left < right)?
	dadd $t0,$t0,$t9 	; (ar[right] >= key && left < right)?
	bnez $t0,end_sort_while2 	
	
						;while ($ar[$right] >= $key && $left < $right)
	
	daddi $s2,$s2,-1	; $right--;
	j sort_while2
end_sort_while2:
	daddi $s2,$s2,0		;nothing
;}
	
sort_while3:	
;{
	dsll $t4,$s1,2 		; adr of left ,
	dadd $t4,$s0,$t4	; *ar + (4*left)
	ld $t4,0($t4)		; t4 = ar[left]
	
	slt $t0,$t4,$t3 	; t0 = (ar[left]< key)?
	slt $t9,$s1,$s2		; t9 = (left < right)?
	dadd $t0,$t0,$t9 	; (ar[left] < key && left < right)?
	bnez $t0,end_sort_while3 	
	
						;while ($ar[$left] <= $key && $left < $right) 
    
	daddi $s1,$s1,1		;$left++;
    j sort_while3
	
end_sort_while3:
	daddi $s2,$s2,0		;nothing
;}

sort_swap:
;{
	slt $t9,$s1,$s2		; t9 = (left < right)?
	bnez $t9,sort_while1 

						;if ($left < $right) 
	
	dsll $t4,$s1,2 		; adr of left ,
	dadd $t4,$s0,$t4	; *ar + (4*left)
	ld $t4,0($t4)		; t4 = ar[left]
	
	dsll $t5,$s2,2 		; adr of right ,
	dadd $t5,$s0,$t5	; *ar + (4*right)
	ld $t5,0($t5)		; t5 = ar[right]
	
	daddi $t0,$t4,0  	; $t = $ar[$left];	
	
	daddi $t4,$t5,0  	; $ar[$left] = $ar[$right];
	dsll $t6,$s1,2 		; adr of left ,
	sd $t4,0($t6)		;save in 
	
	daddi $t5,$t0,0  ;$ar[$right] = $t;
	dsll $t6,$s2,2 		; adr of right ,
	sd $t5,0($t6)		;save in 	
	
end_sort_swap:
	j sort_while1
;}

end_sort_while1:
;{						; left == right == mid
	dsub $t0,$t1,$s1;
	beqz $t0,cut_sort   	;$first_index == $left
	  
						;if ($first_index != $left) 
	
	dsll $t6,$t1,2 		; adr of first_index ,
	dadd $t6,$s0,$t6	; *ar + (4*first_index)
	ld $t6,0($t6)		; t6 = ar[first_index]
	
	dsll $t4,$s1,2 		; adr of left ,
	dadd $t4,$s0,$t4	; *ar + (4*left)
	ld $t4,0($t4)		; t4 = ar[left]
	
	daddi $t6,$t4,0 	 ; //put mid to first(location of key)
						 ; $ar[$first_index] = $ar[$left];
	daddi $t4,$t3,0		 ; //put key into mid
						 ; $ar [$left] = $key;
;}						 ; //continue cut and sort

cut_sort:
;{
	; $this->quick($ar, $first_index, $left - 1);

	daddi $a1,$t1,0
	daddi $a2,$s1,-1
	jal qsort
	
	;$this->quick($ar, $left + 1, $last_index);
	
	daddi $a1,$s1,1
	daddi $a2,$t2,0
	jal qsort
;}	

end_qsort:
;return the stack{
	ld $s0,0($sp) 	 	; so -> *ar
	ld $s1,4($sp) 		; s1 -> left
	ld $s2,8($sp)		; s2 -> right
	daddi $sp,$sp,12
;}


;}	

	
after_echo:	
;{
	daddi $v0,$zero,4       ; set for ascii

	ld $t1,int($zero)
	daddi $t1,$zero,after
	sd $t1,0($t8)           ; write *mes to DATA register
	sd $v0,0($t9)           ; echo  before
;}	
	
	
;need data echo:

	daddi $v0,$zero,2
	daddi $v1,$zero,4       ; set for ascii
	
	dsub $t0,$t0,$t0  ; COUNTER
	dsub $t1,$t1,$t1  ; DATA
	daddi $t0,$t0,10  ; t0 = 10
	daddi $t1,$t1,0  ;
	
data_echo2:
;{
	beqz $t0,end	; t0 == 0 end 

	lwu $a0,AR1($zero) ; $a0 = *ar
	sd $t2,0($a0)   	
	
	sd $t1,0($t8) 
	sd $v0,0($t9) 
	
	
	ld $t2,int($zero)
	daddi $t2,$zero,echo_n
	sd $t2,0($t8)           ; write *mes to DATA register
	sd $v1,0($t9)           ; echo  "\n"
	daddi $t0,$t0,-1
	daddi $t1,$t1,1
	
	j data_echo2;
;}
end:
	halt