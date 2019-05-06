#include<iostream>
#include<string>
using namespace std;
class CCube;
class Spoint {
	public:
		int x,y,z;

		Spoint(int x1, int y1,int z1):x(x1),y(y1),z(z1) {}
		friend string judge(const CCube &A, const CCube &B);
};

class CCube {
	public:
		Spoint a;
		Spoint b;

		CCube(Spoint a1,Spoint b1):a(a1),b(b1) {}
		friend string judge(const CCube &A, const CCube &B);
};

string judge(const CCube &A, CCube &B) {
	//反证法
	if(
	    (A.a.x > A.b.x ? A.a.x: A.b.x) < (B.a.x < B.b.x ? B.a.x: B.b.x)||
	    (A.a.x < A.b.x ? A.a.x: A.b.x) > (B.a.x > B.b.x ? B.a.x: B.b.x)||
	    (A.a.y < A.b.y ? A.a.y: A.b.y) > (B.a.y > B.b.y ? B.a.y: B.b.y)||
	    (A.a.y > A.b.y ? A.a.y: A.b.y) < (B.a.y < B.b.y ? B.a.y: B.b.y)||
	    (A.a.z < A.b.z ? A.a.z: A.b.z) > (B.a.z > B.b.z ? B.a.z: B.b.z)||
	    (A.a.z > A.b.z ? A.a.z: A.b.z) < (B.a.z < B.b.z ? B.a.z: B.b.z)
	) {

		return "have distance" ;
	}
	return "collide";
}
int main() {
	int t;
	int x1,x2,y1,y2,z1,z2;
	cin >> t;
	for(int i = 0 ; i < t ; i++) {
		cin >> x1 >> y1 >>z1>> x2 >> y2>>z2;//创建矩形a
		Spoint a1(x1,y1,z1);
		Spoint b1(x2,y2,z2);
		CCube A(a1,b1);

		cin >> x1 >> y1 >>z1>> x2 >> y2>>z2;//创建矩形B
		Spoint a2(x1,y1,z1);
		Spoint b2(x2,y2,z2);
		CCube B(a2,b2);

		cout << judge(A,B)<< endl;
	}
	return 0;
}
