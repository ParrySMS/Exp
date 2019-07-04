#include<iostream>
using namespace std;

class CComplex{
public:
    double real, image;
//public:
  CComplex(double a=0.0, double b=0.0)
  {   real = a;      image = b;  }
  CComplex(const CComplex &r)
  {   real = r.real;      image = r.image;  }
  void print() const;
 // CComplex& operator+= (const CComplex &r_c);
  const CComplex& operator+= (double c);//实部、虚部加c
  CComplex operator+ (const CComplex &r_c) const;
  CComplex operator+ (double c) const;
  
  //友元函数实现
friend const CComplex& operator+= (CComplex &r_a,const CComplex &r_b){ // 对象(左操作数)  重载符 参数(右操作数  )
   r_a.real += r_b.real;
   r_a.image += r_b.image;
   return r_a;  //成员函数有this指针 可以返回自己对象值
  }
};
void CComplex::print() const{
   cout<<"real="<<real<<",image="<<image<<endl;
}

//CComplex&  CComplex::operator+= (const CComplex &r_c){
//   real+=r_c.real;
//   image+=r_c.image;
//   return *this;
//}

const CComplex& CComplex::operator+= (double c)//实部、虚部加c{
{   real+=c;
    image+=c;
    return *this;
}
CComplex CComplex::operator+ (const CComplex &r_c) const{
   double r,i;
   r=real+r_c.real;
   i=image+r_c.image;
   return CComplex(r,i);
}
CComplex CComplex::operator+ (double c) const{
   double r,i;
   r=real+c;
   i=image+c;
   return CComplex(r,i);
}
int main(){
  CComplex c1(1,2),c2(3,4),c3;
  int c=5;
  c1+=c2;
  c1.print();
//  c1+=c;
//  c1.print();
  c3=c1+=c2;
  c3.print();
  c3=c1+c;
  c3.print();
  return 1;
}

