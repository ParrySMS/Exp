/* 
 * CS:APP Data Lab 
 * 
 * <Please put your name and userid here>
 * 
 * bits.c - Source file with your solutions to the Lab.
 *          This is the file you will hand in to your instructor.
 *
 * WARNING: Do not include the <stdio.h> header; it confuses the dlc
 * compiler. You can still use printf for debugging without including
 * <stdio.h>, although you might get a compiler warning. In general,
 * it's not good practice to ignore compiler warnings, but in this
 * case it's OK.  
 */

#if 0
/*
 * Instructions to Students:
 *
 * STEP 1: Read the following instructions carefully.
 */

You will provide your solution to the Data Lab by
editing the collection of functions in this source file.

INTEGER CODING RULES:
 
  Replace the "return" statement in each function with one
  or more lines of C code that implements the function. Your code 
  must conform to the following style:
 
  int Funct(arg1, arg2, ...) {
      /* brief description of how your implementation works */
      int var1 = Expr1;
      ...
      int varM = ExprM;

      varJ = ExprJ;
      ...
      varN = ExprN;
      return ExprR;
  }

  Each "Expr" is an expression using ONLY the following:
  1. Integer constants 0 through 255 (0xFF), inclusive. You are
      not allowed to use big constants such as 0xffffffff.
  2. Function arguments and local variables (no global variables).
  3. Unary integer operations ! ~
  4. Binary integer operations & ^ | + << >>
    
  Some of the problems restrict the set of allowed operators even further.
  Each "Expr" may consist of multiple operators. You are not restricted to
  one operator per line.

  You are expressly forbidden to:
  1. Use any control constructs such as if, do, while, for, switch, etc.
  2. Define or use any macros.
  3. Define any additional functions in this file.
  4. Call any functions.
  5. Use any other operations, such as &&, ||, -, or ?:
  6. Use any form of casting.
  7. Use any data type other than int.  This implies that you
     cannot use arrays, structs, or unions.

 
  You may assume that your machine:
  1. Uses 2s complement, 32-bit representations of integers.
  2. Performs right shifts arithmetically.
  3. Has unpredictable behavior when shifting an integer by more
     than the word size.

EXAMPLES OF ACCEPTABLE CODING STYLE:
  /*
   * pow2plus1 - returns 2^x + 1, where 0 <= x <= 31
   */
  int pow2plus1(int x) {
     /* exploit ability of shifts to compute powers of 2 */
     return (1 << x) + 1;
  }

  /*
   * pow2plus4 - returns 2^x + 4, where 0 <= x <= 31
   */
  int pow2plus4(int x) {
     /* exploit ability of shifts to compute powers of 2 */
     int result = (1 << x);
     result += 4;
     return result;
  }

FLOATING POINT CODING RULES

For the problems that require you to implent floating-point operations,
the coding rules are less strict.  You are allowed to use looping and
conditional control.  You are allowed to use both ints and unsigneds.
You can use arbitrary integer and unsigned constants.

You are expressly forbidden to:
  1. Define or use any macros.
  2. Define any additional functions in this file.
  3. Call any functions.
  4. Use any form of casting.
  5. Use any data type other than int or unsigned.  This means that you
     cannot use arrays, structs, or unions.
  6. Use any floating point data types, operations, or constants.


NOTES:
  1. Use the dlc (data lab checker) compiler (described in the handout) to 
     check the legality of your solutions.
  2. Each function has a maximum number of operators (! ~ & ^ | + << >>)
     that you are allowed to use for your implementation of the function. 
     The max operator count is checked by dlc. Note that '=' is not 
     counted; you may use as many of these as you want without penalty.
  3. Use the btest test harness to check your functions for correctness.
  4. Use the BDD checker to formally verify your functions
  5. The maximum number of ops for each function is given in the
     header comment for each function. If there are any inconsistencies 
     between the maximum ops in the writeup and in this file, consider
     this file the authoritative source.

/*
 * STEP 2: Modify the following functions according the coding rules.
 * 
 *   IMPORTANT. TO AVOID GRADING SURPRISES:
 *   1. Use the dlc compiler to check that your solutions conform
 *      to the coding rules.
 *   2. Use the BDD checker to formally verify that your solutions produce 
 *      the correct answers.
 */


#endif
/* 
 * bitAnd - x&y using only ~ and | 
 *   Example: bitAnd(6, 5) = 4
 *   Legal ops: ~ |
 *   Max ops: 8
 *   Rating: 1
 */
int bitAnd(int x, int y) {
	return ~(~x | ~y);
}
/* 
 * getByte - Extract byte n from word x
 *   Bytes numbered from 0 (LSB) to 3 (MSB)
 *   Examples: getByte(0x12345678,1) = 0x56
 *   Legal ops: ! ~ & ^ | + << >>
 *   Max ops: 6
 *   Rating: 2
 */
int getByte(int x, int n) {
	int fliter = 0x11;
	int clear_x = x&(fliter<<(n<<1));//get the 11 to needed bits
	int mask = ~(((0x01 << 31) >> (n<<1)) << 1);//clear 11111....
	return (( clear_x >> (n<<1) ) &  mask);

}
/* 
 * logicalShift - shift x to the right by n, using a logical shift
 *   Can assume that 0 <= n <= 31
 *   Examples: logicalShift(0x87654321,4) = 0x08765432
 *   Legal ops: ! ~ & ^ | + << >>
 *   Max ops: 20
 *   Rating: 3 
 */
int logicalShift(int x, int n) {
  return (x >> n) & ~(((0x01 << 31) >> n) << 1);
                     //0x8000 = 1000 0000 ....
}
/*
 * bitCount - returns count of number of 1's in word
 *   Examples: bitCount(5) = 2, bitCount(7) = 3
 *   Legal ops: ! ~ & ^ | + << >>
 *   Max ops: 40
 *   Rating: 4
 */
int bitCount(int x) {
	int res = 0;
	// bit2 xx+1 >>1 get the Count1 --->use to bit4 bit8
	// int bit2 = x & 0x03;// .... 0011
	// res = res + ((bit2+1)>>1);
	int fliter = 0x55 | (0x55<<8);  // 16: 0101 0101 ....
	fliter = fliter | (fliter<<16); //32: 0101 0101
	res = (x & fliter) + ((x>>1) & fliter); // bit2 unit show num; need 00 11
	
	fliter = 0x33 | (0x33<<8);//16: 00 11
	fliter = fliter | (fliter<<16); //32: 
	res = (res & fliter) + ((res>>2) & fliter);// bit 4 unit ,need 0000 1111
	
	fliter = 0x0F | (0x0F<<8);//16: 0000 1111
	fliter = fliter | (fliter<<16); //32: 
	res = (res & fliter) + ((res>>4) & fliter);// bit 8 unit ,need 00 FF 
	
	fliter = 0xFF | (0xFF<<16);//32: 00 FF 00 FF 
	res = (res & fliter)  + ((res>>8) & fliter);// bit 16 unit ,need 0000 FFFF
	
	fliter = 0xFF | (0xFF<<8);//32: 00 00 FF FF 
	res = (res & fliter)  + ((res>>16) & fliter); //bit 32 unit
	
	return res;
 
}
/* 
 * bang - Compute !x without using !
 *   Examples: bang(3) = 0, bang(0) = 1
 *   Legal ops: ~ & ^ | + << >>
 *   Max ops: 12
 *   Rating: 4 
 */
int bang(int x) {
	int mx = ~x+1;
	int res = 1 + ((x|mx)>>31); //1+ [0=0x0000... or other = 0xFFFFF]
	return res;
}
/* 
 * tmin - return minimum two's complement integer 
 *   Legal ops: ! ~ & ^ | + << >>
 *   Max ops: 4
 *   Rating: 1
 */
int tmin(void) {
   return 1<<31;
}
/* 
 * fitsBits - return 1 if x can be represented as an 
 *  n-bit, two's complement integer.
 *   1 <= n <= 32
 *   Examples: fitsBits(5,3) = 0, fitsBits(-4,3) = 1
 *   Legal ops: ! ~ & ^ | + << >>
 *   Max ops: 15
 *   Rating: 2
 */
int fitsBits(int x, int n) {
	int _n = ~n+1;
	int clear_x = x << (32 + _n );
	clear_x = clear_x >> (32 + _n );
	
	return !(x^clear_x); //XOR
  
}
/* 
 * divpwr2 - Compute x/(2^n), for 0 <= n <= 30
 *  Round toward zero
 *   Examples: divpwr2(15,1) = 7, divpwr2(-33,4) = -2
 *   Legal ops: ! ~ & ^ | + << >>
 *   Max ops: 15
 *   Rating: 2
 */
int divpwr2(int x, int n) {
    //(2^n) has one 1,just cut it 
	//eg: 21/4 = 10101/00100 = cut 2 bit = 101
	// neg-- add offset to get close to 0,
	int np = x>>31; //0x000.. or 0xFFFFFF
	int offset = (1<<n) + (~0);//2^n -1 = 000 0 11111 
	offset = offset & np;
	return (x+offset)>>n;
	
}
/* 
 * negate - return -x 
 *   Example: negate(1) = -1.
 *   Legal ops: ! ~ & ^ | + << >>
 *   Max ops: 5
 *   Rating: 2
 */
int negate(int x) {
  return (~x)+1;
}
/* 
 * isPositive - return 1 if x > 0, return 0 otherwise 
 *   Example: isPositive(-1) = 0.
 *   Legal ops: ! ~ & ^ | + << >>
 *   Max ops: 8
 *   Rating: 3
 */
int isPositive(int x) {
  return !(1 & (x>>31)) & !!x;
  //  !(1 & get last bit) to cout 
  // !!x  for x=0
}
/* 
 * isLessOrEqual - if x <= y  then return 1, else return 0 
 *   Example: isLessOrEqual(4,5) = 1.
 *   Legal ops: ! ~ & ^ | + << >>
 *   Max ops: 24
 *   Rating: 3
 */
int isLessOrEqual(int x, int y) {
  int x_y = x + (~y + 1);
  
  int s_x = 1 & (x>>31);
  int s_y = 1 & (y>>31);
  int s_x_y = 1 & (x_y>>31);

  int is_np = (s_x^s_y);//0 same, 1 n p dif
  int s_should = is_np & s_x; //if diff ,should same as s_x
  //int bool_np = 1 + ((x_y+(~0))>>31);//x-y>0--pos1,else neg0 : 1+ 0x000.. or 0xFFFFFF  
   return (!(s_should^s_x_y) & s_x_y);
}
/*
 * ilog2 - return floor(log base 2 of x), where x > 0
 *   Example: ilog2(16) = 4
 *   Legal ops: ! ~ & ^ | + << >>
 *   Max ops: 90
 *   Rating: 4
 */
int ilog2(int x) {
	//divide 2 part
	int num = 0;
	int bit = !!(x>>16);//!! turn to bool
	num = num + (bit<<4); //16 is 2^4,mean if bit =1 has lognum>=4
	//move offset
	bit = !!(x>>(num+8));
	num = num + (bit<<3);
	
	bit = !!(x>>(num+4));
	num = num + (bit<<2);
	
	bit = !!(x>>(num+2));
	num = num + (bit<<1);
	
	bit = !!(x>>(num+1));
	num = num + bit;
	
	//cond
	//int neg1 = (~0);
	//int numiszero = !(num);//is--1,not--0
	//int xisone = !(1^x);//is--1,not--0
	//x>1,num-->count=n,!num_is_zero =1 ,use this to miss neg_1
	//x=1,num-->count=0,use x_is_one to miss neg_1
	//x=0,num-->count=0,should -1,while !num_is_zero = 0 and x_is_one = 0, nothing to miss neg_1
	//return num + !numiszero + xisone + neg1;
	return num + !!(num) + !(1^x) + (~0);
	
}	
/* 
 * float_neg - Return bit-level equivalent of expression -f for
 *   floating point argument f.
 *   Both the argument and result are passed as unsigned int's, but
 *   they are to be interpreted as the bit-level representations of
 *   single-precision floating point values.
 *   When argument is NaN, return argument.
 *   Legal ops: Any integer/unsigned operations incl. ||, &&. also if, while
 *   Max ops: 10
 *   Rating: 2
 */
unsigned float_neg(unsigned uf) {
	unsigned value_uf = uf & 0x7FFFFFFF;
	unsigned sign_uf = uf ^ 0x80000000;// uf & not-s ,^1000.... 
	//NaN s 111 1111 1 xxxx
	if((value_uf > 0x7f800000)){
		return uf;
	}
	
	return sign_uf;
 
}

/* 
 * float_i2f - Return bit-level equivalent of expression (float) x
 *   Result is returned as unsigned int, but
 *   it is to be interpreted as the bit-level representation of a
 *   single-precision floating point values.
 *   Legal ops: Any integer/unsigned operations incl. ||, &&. also if, while
 *   Max ops: 30
 *   Rating: 4
 */
unsigned float_i2f(int x) {
  unsigned Px,S,valid_bit=0;
  unsigned before_shift_res,shift_res,int_num;
  //浮点数的二进制形式
  // -1^s * M * 2^E 
  if(x==0){//0-->
	  return 0;
  }
  
  S = (x<0)?0x80000000:0;//100000 or 000000
  Px = (x<0)?(-x):x;
  //  count first 0  ,get first is 1 goon, 0 end for
  for(shift_res = Px; (before_shift_res^0x7FFFFFFF)>>31 ;valid_bit++){
	  before_shift_res = shift_res;
		shift_res = shift_res <<1;
  }
  
   if ((shift_res & 0x01FF)>0x0100 || (shift_res & 0x03FF)==0x0300){//get last 9,last 11
        int_num=1;
   } else{
        int_num=0;
   }
   
   //32 -1 -8 = 23
  return S + (shift_res>>9) + ((0x9F-valid_bit)<<23) + int_num;

}
/* 
 * float_twice - Return bit-level equivalent of expression 2*f for
 *   floating point argument f.
 *   Both the argument and result are passed as unsigned int's, but
 *   they are to be interpreted as the bit-level representation of
 *   single-precision floating point values.
 *   When argument is NaN, return argument
 *   Legal ops: Any integer/unsigned operations incl. ||, &&. also if, while
 *   Max ops: 30
 *   Rating: 4
 */
unsigned float_twice(unsigned uf) {
   unsigned f = uf;
    if ((f & 0x7F800000) == 0) {// mid 8 exp bit , 0111 1111 1 0000000
        f = ((f & 0x007FFFFF) << 1) | (f & 0x80000000); 
    }else if ((f & 0x7F800000) 
			!= 0x7F800000) {
        f = f + 0x00800000; //+ 0000 0000 1 000 ....
    }
	
    return f;
}
