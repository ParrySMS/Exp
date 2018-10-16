#include <iostream>

#include <string>


using namespace std;

class BinTreeNode {
	public:
		int data;

		BinTreeNode *left;
		BinTreeNode *right;
		BinTreeNode () {
			left = NULL;
			right = NULL;
		}
		~BinTreeNode();
};


class BinTree {
	private:
		BinTreeNode* root;
		int * intTree;
		BinTreeNode * CreateBinTree(int pos);
		void PreOrder(BinTreeNode *t);
		void InOrder(BinTreeNode *t);
		void PostOrder(BinTreeNode *t);


	public:
		int len;
		BinTree() {
			len = 0;
		};
		~BinTree() {};
		void CreateTree(int* TreeAr,int TreeAr_len);
		void PreOrder();//前序
		void InOrder();//中序
		void PostOrder();//后序
		bool isVaildData(int data);
		void setRoot(BinTreeNode* node);

};


bool BinTree::isVaildData(int data) {
	return data>0;
}



// use LevelOrder int array to build a tree
void BinTree::CreateTree(int* TreeAr,int TreeAr_len) {
	intTree = TreeAr;
	len = TreeAr_len;
	root = CreateBinTree(0);
}


//fill the node by recursion
// Level int array
BinTreeNode* BinTree::CreateBinTree(int pos) {

	BinTreeNode* t;
	int data;
	data = intTree[pos];

//	cout<<"data:"<<data<<endl;

	if(!isVaildData(data) || pos>=len) {
		t = NULL;
	} else {
	//	cout<<"new tree node"<<endl;
		t = new BinTreeNode();
		t->data = data;
		t->left = CreateBinTree(2*pos+1);
		t->right = CreateBinTree(2*pos+2);
	}

	return t;
}



//public 先序
void BinTree::PreOrder() {
	PreOrder(root);
	cout<<endl;
}

//private 先序
void BinTree::PreOrder(BinTreeNode *t) {
	if(t!=NULL && isVaildData(t->data)) {
		cout<<t->data<<' ';
		PreOrder(t->left);
		PreOrder(t->right);
	}
}


//public 中序
void BinTree::InOrder() {
	InOrder(root);
	cout<<endl;
}

//private 中序
void BinTree::InOrder(BinTreeNode *t) {

	if(t!=NULL && isVaildData(t->data)) {
		InOrder(t->left);
		cout<<t->data;
		InOrder(t->right);
	}
}

//public 后序
void BinTree::PostOrder() {
	PostOrder(root);
	cout<<endl;
}

//private 后序
void BinTree::PostOrder(BinTreeNode *t) {

	if(t!=NULL && isVaildData(t->data)) {
		PostOrder(t->left);
		PostOrder(t->right);
		cout<<t->data;
	}
}


int main() {
	int t,len,i;
	int * ar;
	BinTree * bin;
	cin>>t;

	while(t--) {
		cin>>len;
		ar = new int[len];

		for(i=0; i<len; i++) {
			cin>>ar[i];
			//	cout<<"ar[i]:"<<ar[i]<<endl;
		}

		bin = new BinTree();
		bin->CreateTree(ar,len);
		bin->PreOrder();

	}


	return 0;
}


