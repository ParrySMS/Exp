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
};


class BinTree {
	private:
		BinTreeNode* root;
		int pos;

		int len ;
		void CreateBinTree();
		void InOrder(BinTreeNode *t);
		void cut(BinTreeNode* node,BinTreeNode* parent) ;
		void cut() ;//cut root

	public:
		int *treeAr;
		BinTree() {};
		~BinTree() {};
		void CreateTree(int len);
		void InOrder();
		void insert(int data);
		void search(int data);
		void cut(int data);


};


//public
void BinTree::InOrder() {
	InOrder(root);
	cout<<endl;
}

//private
void BinTree::InOrder(BinTreeNode *t) {

//	cout<<"inOrder t:"<<t<<endl;

	if(t!=NULL) {
		InOrder(t->left);
		cout<<t->data<<" ";
		InOrder(t->right);
	}
}


void BinTree::CreateTree(int len) {
	pos = 0;
	this->len = len;
	root = NULL;
	CreateBinTree();
}

//for data
void BinTree::cut(int data) {
	BinTreeNode*t = root;
	BinTreeNode*son;

	if(data == t->data) { //cut root
		cut();
	}

	while(t!= NULL) {//search

		son = (data>t->data)?t->right:t->left;
		if(son->data == data) {
			cut(son,t);
			break;
		}
		//not ==
		t = son;//move to next
	}
}

//todo for root
void BinTree::cut() {
	//leaf node ,cut directly
	if(root->left == NULL && root->right == NULL) {
		delete[] root;
		return;
	}

	//one branch
	//--has left
	if(root->left!=NULL && root->right == NULL) {
		BinTreeNode* t = root->left;
		delete[] root;
		root = t;
		return;
	}

	//one branch
	//--has right
	if(root->right!=NULL && root->left == NULL) {
		BinTreeNode* t = root->right;
		delete[] root;
		root = t;
		return;
	}

	//two branch
	if(root->left!=NULL && root->right != NULL) {

		BinTreeNode* t = root;
		BinTreeNode* son = root->right;
		//found the min of right
		while(1) {
			if(son->left == NULL) {
				break;
			}
			t = son;
			son = son->left;
		}
		//cut the origin one
		cut(son,t);
		//cover
		root->data = son->data;
		cout<<"cover:"<<son->data<<endl;
	}


}

//for *
void BinTree::cut(BinTreeNode* node,BinTreeNode* parent) {
	if(parent == NULL) { //root
		cut();
	}
	//leaf node ,cut directly
	if(node->left == NULL && node->right == NULL) {
		(parent->left == node)?
		(parent->left = NULL):(parent->right = NULL);
		delete [] node;
		return;
	}

	//one branch
	//--has left
	if(node->left!=NULL && node->right == NULL) {
		(parent->left == node)?
		(parent->left = node->left):(parent->right = node->left);
		delete [] node;
		return;
	}

	//one branch
	//--has right
	if(node->right!=NULL && node->left == NULL) {
		(parent->left == node)?
		(parent->left = node->right):(parent->right = node->right);
		delete [] node;
		return;
	}

	//two branch
	if(node->left!=NULL && node->right != NULL) {

		BinTreeNode* t = node;
		BinTreeNode* son = node->right;
		//found the min of right
		while(1) {
			if(son->left == NULL) {
				break;
			}
			t = son;
			son = son->left;
		}
		//cover
		node->data = son->data;
		//cut the origin one
		cut(son,t);
	}
}


void BinTree::search(int data) {
	BinTreeNode*t = root;
	int step;

	for(step = 1; t!= NULL; step++) {
		if(t->data == data) {
			cout<<step<<endl;
			break;
		}

		//not ==
		t = (data>t->data)?t->right:t->left;
	}

	if(t == NULL) { //not found
		cout<<"-1"<<endl;
	}
}


void BinTree::insert(int data) {
	BinTreeNode*t = root;
	int num = 100;
	while(num--) {//advoid dead loop
		//insert right
		if(data>t->data && t->right == NULL) {
//				cout<<"insert right:"<<data<<endl;
			t->right = new BinTreeNode();
			t->right->data = data;
//				cout<<"new t right:"<<t->right<<endl;
			break;
		}

		//insert left
		if(data<t->data && t->left == NULL) {
//				cout<<"insert left:"<<data<<endl;
			t->left = new BinTreeNode();
			t->left->data = data;
//				cout<<"new t left:"<<t->left<<endl;
			break;
		}

		//no insert
		t = (data>t->data)?t->right:t->left;

	}

	if(num==0) {
		cout<<"ERROR: while dead"<<endl;
	}
}

void BinTree::CreateBinTree() {
	int i,data;

	data = treeAr[0];
	if(root==NULL) {
//		cout<<"new root,data ="<<data<<endl;
		root = new BinTreeNode();
		root->data = data;
	}
//	cout<<"len:"<<len<<endl;
	for(i=1; i<len; i++) {
		data = treeAr[i];
		insert(data);
	}

}


int main() {
	BinTree * bin;
	int i,j,t,n,m,data;
	cin>>t;
	while(t--) {
		bin = new BinTree();
		cin>>n;
		bin->treeAr = new int[n]();
		for(i = 0; i<n; i++) {
			cin>>bin->treeAr[i];
		}
		//bulid tree
		bin->CreateTree(n);
		bin->InOrder();

		cin>>m;//search
		while(m--) {
			cin>>data;
			bin->cut(data);
			bin->InOrder();
		}

	}

//	delete [] bin;
	return 0;
}

